<?php
declare( strict_types = 1 );

namespace Packages\Questions\App\Services\Crud;

use App\Models\Question;

/**
 * Class QuestionCrudService
 */
class QuestionCrudService
{
    public function store(array $data): Question
    {
        $question = Question::create($data);

        return $question;
    }

    public function update(Question $question, array $data): Question
    {
        $question->update($data);
        $this->attachMedia($question);

        return $question;
    }

    public function delete(Question $question): void
    {
        $question->delete($question);
    }

    public function attachMedia(Question $question)
    {
        foreach (request()->file('images', []) as $image) {
            $question->addMedia($image)->toMediaCollection('images');
        }
    }
}
