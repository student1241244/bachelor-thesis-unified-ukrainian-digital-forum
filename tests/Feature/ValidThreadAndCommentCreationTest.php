<?php

namespace Unit\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Packages\Threads\App\Models\Comment;
use Packages\Threads\App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidCommentCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testValidCommentCreation()
    {
        $threadBody = 'This is a test thread body.';
        $commentBody = 'This is a test comment.';

        $data = [
            'id' => 1,
            'category_id' => 1,
            'title' => 'This is a test thread.',
            'body' => $threadBody,
            'report_count' => 1,
            'report_data' => ['Spam'],
            'is_passcode_user' => 0
        ];
        $thread = Thread::create($data);

        $data = [
            'id' => 1,
            'thread_id' => $thread->id,
            'body' => $commentBody,
            'report_count' => 1,
            'report_data' => ['Spam'],
            'is_passcode_user' => 1
        ];
        Comment::create($data);

        $this->assertDatabaseHas('threads', [
            'body' => $threadBody
        ]);
    }
}