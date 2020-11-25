<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeedlingControllerIndexTest extends TestCase
{
    /** @test */
    public function list_of_seedlings()
    {
        $response = $this->getJson('/api/v1/seedlings');

        $response->assertStatus(200);
        $response->assertJsonStructure(['seedlings']);
    }
}
