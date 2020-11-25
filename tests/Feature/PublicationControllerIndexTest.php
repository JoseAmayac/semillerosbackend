<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicationControllerIndexTest extends TestCase
{
    /** @test */
    public function testExample()
    {
        $response = $this->getJson('/api/v1/publications');

        $response->assertStatus(200);
        $response->assertJsonStructure(['publications']);
    }
}
