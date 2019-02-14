<?php

namespace Tests\Feature\Contact;

use Dymantic\Secretary\MessageReceived;
use Dymantic\Secretary\Secretary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendsContactNotificationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_notification_is_sent_when_contact_message_is_submitted()
    {
        Notification::fake();

        $this->withoutExceptionHandling();

        $response = $this->postJson("/contact", [
            'name'         => 'Test name',
            'email'        => 'test@test.test',
            'phone'        => 'test phone',
            'message_body' => 'Test message'
        ]);
        $response->assertStatus(200);

        Notification::assertSentTo(app(Secretary::class), MessageReceived::class, function ($notification, $channels) {
            return $channels === ['mail'];
        });
    }
}