<?php

namespace App\Http\Controllers;

use App\Http\Requests\QA\PostAnswerRequest;
use App\Http\Requests\QA\UpdateAnswerRequest;
use App\Jobs\SendNewPostEmail;
use App\Models\Comment;
use App\Models\User;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Packages\Questions\App\Models\Category;
use Packages\Dashboard\App\Models\Media;

class QAController extends Controller
{
    public function showQuestions($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $questions = Question::where('category_id', $categoryId)->latest()->paginate(4);
        $count = Question::query()->where('category_id', $categoryId)->count();
        return view('questions.index', compact('questions', 'categoryId', 'count'));
    }

    public function search($query) {
        $questions = Question::search($query)->get();
        $questions->load('user:id,username,avatar');
        return $questions;
    }

    public function editQuestion(Question $question, Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $question->update($incomingFields);

        $comments = $question->comments()->with(['media', 'user'])->latest()->paginate(4);

        $isBookmarked = false;
        if (auth()->check()) {
            $isBookmarked = auth()->user()->bookmarkQuestions()->where('question_id', $question->id)->exists();
        }

        return view('question-details', get_defined_vars());
    }

    public function showEditQuestionForm(Question $question) {
        return view('edit-question', ['question' => $question]);
    }

    public function deleteQuestion(Question $question) {
        $question->delete();
        
        return redirect('/profile/' . auth()->user()->username)->with('success', 'Post successfully deleted.');
    }

    public function showSingleQuestion(Question $question) {
        $question['body'] = strip_tags(Str::markdown($question->body), '<p><ul><ol><li><strong><em><h3><br>');

        $comments = $question->comments()->with(['media', 'user'])->latest()->paginate(4);

        $isBookmarked = false;
        if (auth()->check()) {
            $isBookmarked = auth()->user()->bookmarkQuestions()->where('question_id', $question->id)->exists();
        }

        return view('question-details', get_defined_vars());
    }

    public function show() {
        return view('ask-question');
    }

    public function createNewQuestion(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();
        $newPost = Question::create($incomingFields);

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
