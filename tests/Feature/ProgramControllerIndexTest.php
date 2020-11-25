<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProgramControllerIndexTest extends TestCase
{
    /** @test */
    public function list_of_programs()
    {
        $response = $this->getJson('/api/v1/programs');

        $response->assertStatus(200);
        $response->assertJsonStructure(['programs']);
    }
}
