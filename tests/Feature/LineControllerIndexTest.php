<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LineControllerIndexTest extends TestCase
{
    /** @test */
    public function testExample()
    {
        $response = $this->getJson('/api/v1/lines');

        $response->assertStatus(200);
        $response->assertJsonStructure(['lines']);
    }
}
