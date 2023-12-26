<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\SendNewPostEmail;
use Illuminate\Support\Facades\Log;
use Packages\Dashboard\App\Models\Media;
use App\Http\Requests\QA\PostAnswerRequest;
use Packages\Questions\App\Models\Category;
use App\Http\Requests\QA\UpdateAnswerRequest;

class QAController extends Controller
{
    public function getInterestingQuestions() {
        $interestingQuestions = $this->calculateInterestingQuestions();
        return view('sections.interesting-questions', compact('interestingQuestions'))->render();
    }    

    public function calculateInterestingQuestions() {
        $questions = Question::with(['votes', 'comments.votes'])
                             ->get()
                             ->each(function ($question) {
                                 $question->interesting_rating = $question->calculateInterestingRating($question);
                             });
    
        $sortedQuestions = $questions->sortByDesc('interesting_rating');
        $interestingQuestions = $sortedQuestions->take(3);
    
        return $interestingQuestions;
    }
    
    public function showQuestions($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $questions = Question::where('category_id', $categoryId)->latest()->paginate(4);
        $count = Question::query()->where('category_id', $categoryId)->count();
        $interestingQuestions = $this->calculateInterestingQuestions();
        return view('questions.index', compact('questions', 'categoryId', 'count', 'interestingQuestions', 'category'));
    }

    public function search($query) {
        $questions = Question::search($query)->get();
        $questions->load('user:id,username,avatar');
        return $questions;
    }

    public function editQuestion(Question $question, Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required|max:100',
            'body' => 'required|max:1000',
            'category_id' => 'required|exists:questions_categories,id',
            'is_agree' => 'required',
        ]);
        
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $question->update($incomingFields);
        $interestingQuestions = $this->calculateInterestingQuestions();
        $comments = $question->comments()->with(['media', 'user'])->latest()->paginate(4);

        $isBookmarked = false;
        if (auth()->check()) {
            $isBookmarked = auth()->user()->bookmarkQuestions()->where('question_id', $question->id)->exists();
        }

        return view('question-details', get_defined_vars());
    }

    public function showEditQuestionForm(Question $question) {
        $categories = Category::get()->pluck('title', 'id')->toArray();

        return view('edit-question', get_defined_vars());
    }

    public function deleteQuestion(Question $question) {
        $question->delete();
        
        return redirect('/profile/' . auth()->user()->username)->with('success', 'Post successfully deleted.');
    }

    public function showSingleQuestion(Question $question) {
        $question['body'] = strip_tags(Str::markdown($question->body), '<p><ul><ol><li><strong><em><h3><br><script>');

        $comments = $question->comments()->with(['media', 'user'])
                                      ->orderBy('votes_count', 'desc')
                                      ->paginate(4);
        $interestingQuestions = $this->calculateInterestingQuestions();
        $isBookmarked = false;
        if (auth()->check()) {
            $isBookmarked = auth()->user()->bookmarkQuestions()->where('question_id', $question->id)->exists();
        }

        return view('question-details', get_defined_vars());
    }

    public function show() {
        $categories = Category::get()->pluck('title', 'id')->toArray();

        return view('questions.create', get_defined_vars());
    }

    public function createNewQuestion(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required|max:100',
            'body' => 'required|max:1000',
            'category_id' => 'required|exists:questions_categories,id',
            'images' => 'array|max:6',
            'images.*' => 'mimes:jpg,jpeg,png|max:2048',
            'is_agree' => 'required',
        ]);
        
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();
        $newPost = Question::create($incomingFields);

        foreach ($request->file('images', []) as $image) {
            $newPost->addMedia($image)->toMediaCollection('images');
        }
        
        dispatch(new SendNewPostEmail(['sendTo' => auth()->user()->email, 'name' => auth()->user()->username, 'title' => $newPost->title]));

        return redirect("/question-details/{$newPost->id}")->with('success', 'New post successfully created.');
    }

    public function postAnswer(int $question_id, PostAnswerRequest $request)
    {
        $question = Question::query()->findOrFail($question_id);

        $data = $request->only(['body']);
        $data['question_id'] = $question->id;
        $data['user_id'] = auth()->id();
        $answer = Comment::create($data);
        $user = auth()->user();
        $user->bonus_points += 10;
        $user->save();

        foreach ($request->file('images', []) as $image) {
            $answer->addMedia($image)->toMediaCollection('images');
        }

        return response()->json([
            'message' => 'Answer successfully posted.',
        ]);
    }

    public function updateAnswer($id, UpdateAnswerRequest $request)
    {
        $answer = Comment::query()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $answer->update([
            'body' => $request->input('body'),
        ]);

        $removeImages = $request->input('remove_images', []);
        if (count($removeImages)) {
           foreach (Media::query()->whereIn('id', $removeImages)->get() as $media) {
               $media->delete();
           }
        }

        foreach ($request->file('images', []) as $image) {
            $answer->addMedia($image)->toMediaCollection('images');
        }

        return response()->json([
            'message' => 'Answer successfully updated.',
        ]);
    }

    public function getAnswer($id)
    {
        $answer = Comment::query()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $images = [];
        foreach($answer->getMedia('images') as $image) {
            $images[] = [
                'id' => $image->id,
                'url' => $image->getUrl('100x100'),
            ];
        }

        return response()->json([
            'id' => $id,
            'body' => $answer->body,
            'images' => $images,
        ]);
    }

    public function deleteAnswer($id)
    {
        $answer = Comment::query()->findOrFail($id);
        $answer->delete();

        return redirect("/question-details/{$answer->question_id}")->with('success', 'Answer successfully deleted.');
    }

    public function bookmark($id)
    {
        if (auth()->guest()) {
            return redirect('/');
        }

        $question = Question::query()->findOrFail($id);
        $user = auth()->user();

        $user->bookmarkQuestions()->toggle($question);

        return redirect("/question-details/" . $id);
    } 
}
