<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProgramControllerShowTest extends TestCase
{
    /** @test */
    public function program_id_not_exists()
    {
        $response = $this->getJson('/api/v1/programs/100');

        $response->assertStatus(404);
        $response->assertJson(["message" => "No query results for model [App\\Models\\Program] 100"]);
    }

    /** @test */
    public function program_id_is_valid_correct_response(){
        $response = $this->getJson('/api/v1/programs/2');

        $response->assertStatus(200);
        $response->assertJsonStructure(["program"]);
    }
}
