<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;
use Tests\TestCase;

class PostTest extends TestCase
{
    
    use RefreshDatabase;
    use WithFaker;

    public function test_show_posts() : void {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/api/posts/')
        ->assertStatus(200);
    }

    public function test_show_post_by_id()
    {
        $user = User::factory()->create();

        $id = '1';

        $this->actingAs($user)->get('/api/post/{id}')
        ->assertStatus(200);
    }

    public function test_create_post()
    {
        
        $user = User::factory()->create();

        $formData = [
            'user_id'=> $this->faker->randomDigit(),
            'text'=> $this->faker->sentence()
        ];

        // dd($formData);
        $this->actingAs($user)
        ->post('/api/posts', $formData)
        ->assertStatus(200);
    }

    public function test_update_post()
    {
        $user = User::factory()->create();

        $id = '1';

        $this->actingAs($user)
        ->post('/api/post/{$id}/update')
        ->assertStatus(200);
    }

    public function test_delete_post()
    {
        $user = User::factory()->create();

        $id = '1';

        $this->actingAs($user)
        ->delete('/api/post/{$id}/delete')
        ->assertStatus(200);
    }
}
