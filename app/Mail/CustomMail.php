<?php
/*
 * Students: Tibudan, Chelsea Shaira E. | Los Baños, John Christian H.
 * Date Started: May 28, 2023
 * Subject: Integrative Programming | Application Development and Emerging Technologies
 * Legacy: This system is for grading purposes only
*/
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Email Subject
   *
   * @var string
   */
  public string $emailSubject;

  /**
   * Raw Email Body
   *
   * @var string
   */
  public string $emailBody;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(string $subject, string $body)
  {
    $this->emailSubject = $subject;
    $this->emailBody = $body;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->subject($this->emailSubject)
      ->replyTo(Auth()->user()->email)
      ->view("emails.custom");
  }
}
