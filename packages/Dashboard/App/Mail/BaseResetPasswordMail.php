<?php

namespace Packages\Dashboard\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BaseResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /*
     * @var array
     */
    public $params;

    /**
     * Create a new message instance.
     *
     * @param array $params
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->subject(trans('dashboard::auth.password_subject'))
            ->markdown('tpx_dashboard::emails.reset_password');
    }
}
