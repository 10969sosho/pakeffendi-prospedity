<?php

namespace Tests\Feature;

use App\Mail\InquiryMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactUsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
        ]);
    }

    /** @test */
    public function it_stores_inquiry_and_sends_email_with_selected_subject()
    {
        Mail::fake();

        config([
            'contact.to_address' => 'admin@prospedity.com',
            'contact.to_name' => null,
        ]);

        $payload = [
            'name' => 'Test User',
            'email' => 'user@example.com',
            'whatsapp' => '+6281234567890',
            'subject' => 'tanya properti',
            'property_number' => 'PN251200001',
            'note' => 'Halo, saya mau tanya properti.',
        ];

        $this->post(route('contact-us.store'), $payload)
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('inquiries', [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'whatsapp' => $payload['whatsapp'],
            'subject' => $payload['subject'],
            'property_number' => $payload['property_number'],
            'note' => $payload['note'],
        ]);

        Mail::assertSent(InquiryMail::class, function (InquiryMail $mail) use ($payload) {
            return $mail->hasTo('admin@prospedity.com')
                && ($mail->envelope()->subject === 'Tanya Properti - ' . $payload['property_number']);
        });
    }
}
