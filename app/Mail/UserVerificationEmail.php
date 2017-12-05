<?php

namespace App\Mail;

use App\Models\VerificationCode;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $verificationCode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VerificationCode $verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
                    ->subject('注册验证码邮件')
                    ->markdown('mail.user')
                    ->with([
                        'email' => $this->verificationCode->email,
                        'code' => $this->verificationCode->code,
                    ]);
    }
}
