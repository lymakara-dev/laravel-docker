<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // get all categories
    public function test_can_all_categories(): void
    {


        $response = $this->get('/api/categories');
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Get all categories success!',

            ]);
    }

    // create category
    public function test_can_create_category(): void
    {
        $response = $this->post('/api/categories', [
            'name' => 'Food',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Category created successfully',
            ]);
    }

    // get category by id
    public function test_can_get_category_by_id(): void
    {
        $response = $this->get('/api/categories/1');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Get category success',
            ]);
    }

    // update category
    public function test_can_update_category(): void
    {
        $response = $this->patch('/api/categories/1', [
            'name' => 'Updated Category',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Category updated successfully',
            ]);
    }

    // delete category
    public function test_can_delete_category(): void
    {
        $response = $this->delete('/api/categories/1');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Category deleted successfully',
            ]);
    }

    // get category not found
    public function test_can_get_category_not_found(): void
    {
        $response = $this->get('/api/categories/999');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Category not found!',
            ]);
    }

    // test cannot create category with empty name
    public function test_cannot_create_category_with_empty_name()
    {
        $response = $this->postJson('/api/categories', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    // test category name must be unique
    public function test_category_name_must_be_unique(): void
    {
        Category::create(['name' => 'Unique Category']);

        $response = $this->postJson('/api/categories', [
            'name' => 'Unique Category',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    // test category name must be string
    public function test_category_name_must_be_string(): void
    {
        $response = $this->postJson('/api/categories', [
            'name' => 12345,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    // test category name must be not empty
    public function test_category_name_must_be_not_empty(): void
    {
        $response = $this->postJson('/api/categories', [
            'name' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
}
