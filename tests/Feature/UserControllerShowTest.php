<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerShowTest extends TestCase
{
    /** @test */
    public function user_id_not_exists()
    {
        $response = $this->getJson('/api/v1/users/100');

        $response->assertStatus(404);
        $response->assertJson(["message" => "No query results for model [App\\Models\\User] 100"]);
    }

    /** @test */
    public function user_id_is_valid_correct_response(){
        $response = $this->getJson('/api/v1/users/2');

        $response->assertStatus(200);
        $response->assertJsonStructure(["user"]);
    }
}
