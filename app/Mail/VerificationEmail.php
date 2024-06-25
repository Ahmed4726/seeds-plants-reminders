<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $appName;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->appName = config('app.name');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verify your email address')
                    ->view('emails.verification')
                    ->with([
                        'name' => $this->user->name,
                        'verificationUrl' => $this->generateVerificationUrl(),
                        'appName' => $this->appName,
                    ]);
    }

    /**
     * Generate the verification URL for the user.
     *
     * @return string
     */
    protected function generateVerificationUrl()
    {
        return route('verify.email', [
            'id' => $this->user->id,
            'hash' => sha1($this->user->getEmailForVerification()),
        ]);
    }
}
