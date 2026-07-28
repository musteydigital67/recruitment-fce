<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Application $application) {}

    public function envelope(): Envelope
    {
        $subject = match ($this->application->status) {
            'interview' => 'Interview Scheduled - '.$this->application->position->title,
            'shortlisted' => 'Application Shortlisted - '.$this->application->position->title,
            'rejected' => 'Application Update - '.$this->application->position->title,
            default => 'Application Status Update - '.$this->application->position->title,
        };

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.application-status-updated',
        );
    }
}