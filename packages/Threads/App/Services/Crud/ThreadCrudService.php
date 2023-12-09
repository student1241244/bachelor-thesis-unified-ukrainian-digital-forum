<?php
declare( strict_types = 1 );

namespace Packages\Threads\App\Services\Crud;

use Packages\Threads\App\Models\Thread;

/**
 * Class ThreadCrudService
 */
class ThreadCrudService
{
    public function store(array $data): Thread
    {
        $thread = Thread::create($data);
        $this->attachMedia($thread);

        return $thread;
    }

    public function update(Thread $thread, array $data): Thread
    {
        $thread->update($data);
        $this->attachMedia($thread);

        return $thread;
    }

    public function delete(Thread $thread): void
    {
        $thread->delete($thread);
    }

    public function attachMedia(Thread $thread)
    {
        if(request()->hasFile('image')) {
            $thread->addMediaFromRequest('image')->toMediaCollection('image');
        }
    }
}
