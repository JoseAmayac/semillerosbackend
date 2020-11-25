<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicationControllerShowTest extends TestCase
{
    /** @test */
    public function publication_id_not_exists()
    {
        $response = $this->getJson('/api/v1/publications/100');

        $response->assertStatus(404);
        $response->assertJson(["message" => "No query results for model [App\\Models\\Publication] 100"]);
    }

    /** @test */
    public function publication_id_is_valid_correct_response(){
        $response = $this->getJson('/api/v1/publications/2');
        $response->assertStatus(200);
        $response->assertJsonStructure(["publication"]);
    }
}
