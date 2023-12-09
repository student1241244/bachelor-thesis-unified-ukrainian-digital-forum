<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Packages\Threads\App\Models\Thread;
use Packages\Threads\App\Models\Comment as ThreadComment;

class ReportService
{
    const LIMIT = 10;

    const TYPE_THREAD = 'thread';
    const TYPE_THREAD_COMMENT = 'thread_comment';
    const TYPE_QUESTION = 'question';
    const TYPE_QUESTION_ANSWER = 'question_answer';

    /**
     * @param string $type
     * @param int $id
     * @return Model|null
     */
    public function getInstanceByTypeAndId(string $type, int $id):? Model
    {
        switch ($type) {
            case self::TYPE_THREAD:
                return Thread::find($id);
            case self::TYPE_THREAD_COMMENT:
                return ThreadComment::find($id);
            case self::TYPE_QUESTION:
                return Question::find($id);
            case self::TYPE_QUESTION_ANSWER:
                return Comment::find($id);
        }

        return null;
    }

    /**
     * @param string $type
     * @param int $id
     * @param string $reason
     * @return void
     */
    public function addReport(string $type, int $id, string $reason)
    {
        $instance = $this->getInstanceByTypeAndId($type, $id);
        if ($instance) {
            $instance->report_count++;
            $report_data = $instance->report_data ?? [];
            $report_data[] = $reason;
            $instance->report_data = $report_data;
            $instance->save();
        }
    }

    public function cleanReport(string $type, int $id)
    {
        $instance = $this->getInstanceByTypeAndId($type, $id);
        if ($instance) {
            $instance->report_count = 0;
            $instance->report_data = [];
            $instance->save();
        }
    }

    /**
     * @param Model $model
     * @return string|null
     */
    public function getTypeByModel(Model $model):? string
    {
        if ($model instanceof Thread) {
            return self::TYPE_THREAD;
        } elseif ($model instanceof ThreadComment) {
            return self::TYPE_THREAD_COMMENT;
        } elseif ($model instanceof Question) {
            return self::TYPE_QUESTION;
        } elseif ($model instanceof Comment) {
            return self::TYPE_QUESTION_ANSWER;
        }

        return null;
    }

    /**
     * @param $report_data
     * @return string
     */
    public function formatReportData(Model $model): string
    {
        $report_data = $model->report_data ?? [];

        $reasons = [];
        foreach ($report_data as $reason) {
            if (isset($reasons[$reason])) {
                $reasons[$reason]++;
            } else {
                $reasons[$reason] = 1;
            }
        }

        $html = '';
        foreach ($reasons as $reason => $count) {
            $html .= "{$reason}: ({$count})<br/>";
        }
        if (count($report_data) >= self::LIMIT) {
            $html .= '<a href="#" class="js-clean-report" data-type="'.$this->getTypeByModel($model).'" data-id="'.$model->id.'"><i class="fa fa-check"></i></a>';
        }

        return $html;
    }
}
