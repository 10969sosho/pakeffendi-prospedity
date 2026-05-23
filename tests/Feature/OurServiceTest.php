<?php

namespace Tests\Feature;

use App\Models\OurService;
use App\Models\ServicePackage;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OurServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([
            ValidateCsrfToken::class,
            VerifyCsrfToken::class,
        ]);
        $this->user = User::factory()->create(['role' => 'admin']);
    }

    /** @test */
    public function it_can_create_service_with_empty_description()
    {
        $this->actingAs($this->user)
            ->post(route('admin.our-services.store'), [
                'title' => 'Test Service',
                'reference_url' => 'https://example.com',
                'content' => '', // Empty description
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.our-services.index'))
            ->assertSessionHas('success', 'Service created successfully.');

        $this->assertDatabaseHas('our_services', [
            'title' => 'Test Service',
            'reference_url' => 'https://example.com',
            'content' => null,
            'is_active' => true,
        ]);
    }

    /** @test */
    public function it_can_create_service_with_filled_description()
    {
        $this->actingAs($this->user)
            ->post(route('admin.our-services.store'), [
                'title' => 'Test Service',
                'reference_url' => 'https://example.com',
                'content' => '<p>This is a test description with HTML content.</p>',
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.our-services.index'))
            ->assertSessionHas('success', 'Service created successfully.');

        $this->assertDatabaseHas('our_services', [
            'title' => 'Test Service',
            'reference_url' => 'https://example.com',
            'content' => '<p>This is a test description with HTML content.</p>',
            'is_active' => true,
        ]);
    }

    /** @test */
    public function it_displays_packages_on_public_page()
    {
        ServicePackage::create([
            'name' => 'Test Package',
            'slug' => 'test-package',
            'short_description' => 'Test description',
            'normal_price' => 100000,
            'discount_price' => null,
            'is_active' => true,
            'order' => 1,
        ]);

        $response = $this->get(route('our-services'));

        $response->assertStatus(200);
        $response->assertSee('Test Package');
        $response->assertSee('Beli Paket');
    }

    /** @test */
    public function it_displays_discount_price_when_available()
    {
        ServicePackage::create([
            'name' => 'Discount Package',
            'slug' => 'discount-package',
            'short_description' => 'Test discount',
            'normal_price' => 100000,
            'discount_price' => 90000,
            'is_active' => true,
            'order' => 1,
        ]);

        $response = $this->get(route('our-services'));

        $response->assertStatus(200);
        $response->assertSee('Discount Package');
        $response->assertSee('Rp 100.000');
        $response->assertSee('Rp 90.000');
    }

    /** @test */
    public function it_can_update_service_with_empty_description()
    {
        $service = OurService::create([
            'title' => 'Original Service',
            'content' => 'Original content',
            'is_active' => true,
            'order' => 1,
        ]);

        $this->actingAs($this->user)
            ->put(route('admin.our-services.update', $service), [
                'title' => 'Updated Service',
                'content' => '', // Empty description
                'reference_url' => 'https://updated.com',
            ])
            ->assertRedirect(route('admin.our-services.index'))
            ->assertSessionHas('success', 'Service updated successfully.');

        $this->assertDatabaseHas('our_services', [
            'id' => $service->id,
            'title' => 'Updated Service',
            'content' => null,
            'reference_url' => 'https://updated.com',
            'is_active' => false,
        ]);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $this->actingAs($this->user)
            ->post(route('admin.our-services.store'), [
                'title' => '', // Empty title
                'content' => '', // Empty content (should be allowed now)
                'reference_url' => 'invalid-url', // Invalid URL
            ])
            ->assertSessionHasErrors(['title', 'reference_url'])
            ->assertSessionDoesntHaveErrors(['content']); // Content should not have errors since it's nullable
    }
}
