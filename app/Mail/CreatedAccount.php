<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Resend\Laravel\Facades\Resend;


class CreatedAccount extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Our Platform',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.created-account',
            with: ['user' => $this->user],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Send the email via Resend.
     */
    public function build(): self
    {
        // Send email using Resend
        Resend::emails()->send([
            'from' => env('RESEND_FROM_EMAIL'),  // From email from .env
            'to' => $this->user->email,          // To email from the user
            'subject' => $this->envelope()->subject,  // Subject
            'text' => 'Welcome to our platform, ' . $this->user->name,  // Plain text content
            'html' => view('emails.created-account', ['user' => $this->user])->render(), // Render HTML view
        ]);

        return $this; // Return the Mailable object to continue the chain
    }
}
