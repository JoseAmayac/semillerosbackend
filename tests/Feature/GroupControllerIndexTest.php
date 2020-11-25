<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupControllerIndexTest extends TestCase
{
    /** @test */
    public function list_of_groups()
    {
        $response = $this->getJson('/api/v1/groups');

        $response->assertStatus(200);
        $response->assertJsonStructure(['groups']);
    }
}
