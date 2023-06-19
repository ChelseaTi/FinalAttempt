<?php
/*
 * Students: Tibudan, Chelsea Shaira E. | Los Baños, John Christian H.
 * Date Started: May 28, 2023
 * Subject: Integrative Programming | Application Development and Emerging Technologies
 * Legacy: This system is for grading purposes only
*/
namespace App\Notifications;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Webhook\WebhookChannel;
use NotificationChannels\Webhook\WebhookMessage;
use Illuminate\Notifications\Messages\MailMessage;

class EmployeeDeleted extends Notification
{
  use Queueable;

  public Employee $employee;

  /**
   * Create a new notification instance.
   *
   * @param Employee $employee
   * @return void
   */
  public function __construct(Employee $employee)
  {
    $this->employee = $employee;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail', WebhookChannel::class];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    return (new MailMessage)
      ->subject("Employee Deleted")
      ->replyTo(Auth()->user()->email)
      ->error()
      ->greeting("Hello!")
      ->line(__("messages.employee.deleted", [
        "name" => $this->employee->firstname ." ". $this->employee->lastname,
      ]))
      ->action('View', route('employees.employee', $this->employee->id));
  }

  /**
   * Get the webhook representation of the notification.
   *
   * @param mixed $notifiable
   * @return WebhookMessage
   */
  public function toWebhook($notifiable)
  {
    return WebhookMessage::create()->data([
      "event" => "employee.deleted",
      "data" => $this->employee->toArray(),
    ]);
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    return [];
  }
}
