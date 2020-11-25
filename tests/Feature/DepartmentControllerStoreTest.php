<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartmentControllerStoreTest extends TestCase
{
    private $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZjVkNmI3ZThiM2Y1ZWU2YzNjMWI5MDU3NjZkOTQ2NGUzYzVhMzY5OGY2MWZkOTY4MjA2ZThiOTcyODk3NjViZjYxMzcyMDA5ODQ3MjAwN2EiLCJpYXQiOjE2MDYxODA4NjMsIm5iZiI6MTYwNjE4MDg2MywiZXhwIjoxNjA2MjY3MjYzLCJzdWIiOiIyIiwic2NvcGVzIjpbIioiXX0.n-fIkPXH_ujgE0TWzew_DTfV32e_PAiIEyMHnW5-gHifNY_P4JAbcA6qj_lB5ov4RmJgr9GtKwBod0antLz29kYSfSGGsV1Ujh-44AdWMCAqnB3YnceN3s68qGjudSDtALflkNRo4_f0mvpb1T7evXFfAmx1YUz7MUNWok32TD46EpRspaDyYIl7TMUPdhxjG9sn1vbYIB-NEJkXvypsY3myvSCSbt9AMRKXcSLe59vYneK80CzpGokopR0mneIrydpDbIsSbYeOsawcikydbj0cghwg_Fd68Bq7RhZSl-4qpN64kDUBLu4-V7_MDK2KrpYyi4OQCjFChEDB0Hkccx63siktJKSMVSMiq4f2QOB3KJx3gfvB7USN_rdwvOpT2EUY19_adtglILLzMK9VFfSKoqz893Zav2H7Y-Kf4fRt4UvguBHWGDMlSeetVnp9yc-AFOhJPrju6yv56PMh8U4xJXJq8fhDGWEbJL-2m2EQrirtS76yhm_7zZad1h2dCZXHP6HFE-9q17KfW9G3jr-fmub5qcm8v9VGuHp47Dy4y9zwkhFidTonSlQQIOxsuVSJcAEw6m0PsXI8H46woE5RyQs9Cs78A-61QDYBmNcE7vcH6dPk2os09o-XWG2goWVVAExms_DVo9dXWmok_T8Ul8DfA0hMBgOuFZ4FRFc";
    
    /** @test */
    public function store_return_validation_request_messages()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->postJson('/api/v1/departments',[]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message','errors']);
        $response->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function store_return_correct_response_after_save()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->postJson('/api/v1/departments',[
            "name" => "Estudios sociales y empresariales 452",
            "description" => "Departamento de Estudios sociales y empresariales de la UAM"
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['department']);
    }

    /** @test */
    public function store_without_token_in_headers_middleware_error()
    {
        $response = $this->postJson('/api/v1/departments',[
            "name" => "Estudios sociales y empresariales",
            "description" => "Departamento de Estudios sociales y empresariales de la UAM"
        ]);

        $response->assertStatus(401);
        $response->assertJsonStructure(['message','code']);
        $response->assertJson([
            'message' => 'Token de autenticación invalido',
            'code' => 'invalid_token'
        ]);
    }
}
