<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartmentControllerIndexTest extends TestCase
{
    /** @test */
    public function list_of_departments()
    {
        $response = $this->getJson('/api/v1/departments');

        $response->assertStatus(200);
        $response->assertJsonStructure(['departments']);
    }
}
