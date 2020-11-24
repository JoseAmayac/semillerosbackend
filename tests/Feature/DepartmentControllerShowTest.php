<?php

namespace Tests\Feature;

use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartmentControllerShowTest extends TestCase
{
    /** @test */
    public function department_id_not_exists()
    {
        $response = $this->getJson('/api/v1/departments/100');

        $response->assertStatus(404);
        $response->assertJson(["message" => "No query results for model [App\\Models\\Department] 100"]);
    }

    /** @test */
    public function department_id_is_valid_correct_response(){
        $response = $this->getJson('/api/v1/departments/1');
        $response->assertStatus(200);
        $response->assertJsonStructure(["department"]);
    }
}
