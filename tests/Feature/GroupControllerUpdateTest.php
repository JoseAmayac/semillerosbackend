<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupControllerUpdateTest extends TestCase
{
    private $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYjc5NDIzZmRjYjRkZjc5MWQzODBiNTA3ZDU4MjE3YjUwYWMyZjgxOTk2NGZkNWIwN2VkMTA0OTY1ZmNlNDdhM2U3YzRjOWZiOThiZDAyZTEiLCJpYXQiOjE2MDYxODUwMDksIm5iZiI6MTYwNjE4NTAwOSwiZXhwIjoxNjA2MjcxNDA5LCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.nM5UIDwQoqVD27mw203CjKQv0gwpD7rhAdnF64LufKWhr56y-2dxTD_xdRvJwzWg8TqkNFiYKlrO21rwX4-qbh90nT5mHUFHgcvhc4UFTCZmNoNkH_zFaYsMAq35UXOj_YXioFL4vhcoOwgkF4ceRKhaLqvy7g-LXb2tnsWu5wSWeLG525I_I2vqZRuziq7XlxnRwDBJ-oiwiiKJzsU529OuDOcOmtvmNy-k-IaSdTw6YhZDwH8l7EDdlUxTBbBHlUt8XUzQnLPO0HFLBdfHSDN_aq6LzhAY73PvI8Fd7wF7M1Y3AS7BvHq4okek152o8AYZSlQMreE15L07-WO0fogctXvvD4CI2wMBOkORuydCCJGjUlFo1XuB6XsEz2ePPHWR5vH5dcimaqrc3U-UuocR_-QudjFJahZ-QrC2y0LyHLKfr3S-qeB2x4O8atk2HtY_2fN6wPey1vH3FcYuZrIwzfu8oVKJg9Qf78JfunveeE-2oCY09lYMkP8Bmnmg5S7OtY6zdns92pqMmXZjR5PG7BAKWdjr19a-PyhPv8f1NzwRRyWXfgHptPB-H_TpEXjbSSJPPYfbW8npS7Qq1d7fWLJ-QPi04Q9OtloNXRQiJ3YemrPDAigrmpX80nHyTZyqrbb4O_BuFA2ObtmaTobHkVyDpgQcCvdRIT7eBMI";

    /** @test */
    public function update_group_without_token_middleware_error()
    {
        $response = $this->putJson('/api/v1/groups/2',[]);

        $response->assertStatus(401);
        $response->assertJsonStructure(['message','code']);
        $response->assertJson([
            'message' => 'Token de autenticación invalido',
            'code' => 'invalid_token'
        ]);
    }

    /** @test */
    public function update_group_return_request_validation_messages()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson('/api/v1/groups/2',[]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message','errors']);
        $response->assertJsonValidationErrors(['name','department_id']);
    }

    /** @test */
    public function update_group_return_invalid_group_id()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson('/api/v1/groups/100',[
            "name" => "grupo modificado",
            "description" => "Descripción del grupo modificado",
            "department_id" => 2
        ]);

        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);
        $response->assertJsonMissingValidationErrors(["message" => "No query results for model [App\\Models\\Group] 100"]);
    }

    /** @test */
    public function update_group_return_correct_response()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson('/api/v1/groups/2',[
            "name" => "grupo modificado 3",
            "description" => "Descripción del grupo modificado",
            "department_id" => 3,
            "id" => 2
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['group','message']);
        $response->assertJson(['message' => 'Grupo de investigación actualizada correctamente']);
    }
}
