<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_products_page(): void
    {
        $this->get(route('products.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_products_page(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Secure USB Drive 64GB',
        ]);

        $this->actingAs($user)
            ->get(route('products.index'))
            ->assertOk()
            ->assertSee('All Products')
            ->assertSee($product->name);
    }

    public function test_authenticated_user_can_create_product(): void
    {
        $user = User::factory()->create();

        $payload = [
            'name' => 'Hardware Security Key',
            'description' => 'Security key untuk autentikasi multi-factor.',
            'price' => 450000,
        ];

        $this->actingAs($user)
            ->post(route('products.store'), $payload)
            ->assertRedirect(route('products.index'))
            ->assertSessionHas('message', 'Product Added Successfully.');

        $this->assertDatabaseHas('products', $payload);
    }

    public function test_create_product_requires_valid_payload(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('products.create'))
            ->post(route('products.store'), [
                'name' => '',
                'description' => '',
                'price' => 'not-a-number',
            ])
            ->assertRedirect(route('products.create'))
            ->assertSessionHasErrors(['name', 'description', 'price']);
    }

    public function test_authenticated_user_can_view_product_detail(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->get(route('products.show', $product->id))
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee($product->description);
    }

    public function test_authenticated_user_can_update_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $payload = [
            'name' => 'Updated Secure Product',
            'description' => 'Deskripsi produk berhasil diperbarui.',
            'price' => 500000,
        ];

        $this->actingAs($user)
            ->put(route('products.update', $product->id), $payload)
            ->assertRedirect(route('products.index'))
            ->assertSessionHas('message', 'Product updated successfully');

        $this->assertDatabaseHas('products', array_merge([
            'id' => $product->id,
        ], $payload));
    }

    public function test_authenticated_user_can_delete_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->delete(route('products.destroy', $product->id))
            ->assertRedirect(route('products.index'))
            ->assertSessionHas('message', 'Product deleted successfully');

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
