<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LineControllerUpdateTest extends TestCase
{
    use DatabaseTransactions;
    private $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiY2NjMGEzYjU0NDc4YTkxYWNhNDM1OTUzMzkxMjU1ZWU0NjNhYzNjMzQ3MTljZTFhNTgzMTE4Yzk0NTNlZTljMzY3MTJkM2ZmNDY4YWQ3ODIiLCJpYXQiOjE2MDYyNjQ1NDMsIm5iZiI6MTYwNjI2NDU0MywiZXhwIjoxNjA2MzUwOTQzLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.hygWS4qxWFY6L0nSDeBDIjNwc3X1jUxqyboxg4hMMzbCZQC6j8LffzEKwCyB2XyrGqgKCsmJcdztDiwaduXXkHDG4rmbVnDhjFvkdWknQorfaNwwWGkjBV18DpmAfhoVryyZKyL_xQ-O4KF7dUUN9kuuvBZpGLmU42WmV66WcNZ6MBTxmHlq6mRQgnbrQmr2c0Iq02zfOrdjtiWPmudp03fP3iX39CD1jOSuL7Il22ZpP8KEquLaJMOJsDM-A3huSOu7-dtibCVn05Elhz5pkwLbV7hbAtM7hUTw4KlLbsv7ViS02_gaXLpNfuYjzyrC5v5bNoh-Q169cj5ppto7rmkmFzXlBbxdIvOP-cf5ye8kCHxT-FuZLbhSQrrWuGryK-FuEf1zEmCRBt6wbIsBrH65NPI6ipBZWumG73yaSQQ-pR2FJFUbzAEjiv-rTI9iFXuXQwA_tj9--hneFcl-jgcdZOklhkqxH0ve6zXu8ifOEF-EscL5xXN91bw99bprjidO7_FBYtJEIDXpPuimOGQlzQTNgJTnJ7TP4WHUuCMvXV-hAvLVoUl8aRrlgFYlVuJdhpnuZSuOkiO3tSvtOD-sEHpP4ecNuBvqe71X9L70C4Rz5L7QHvM9I987RcntPXEFcYdIADpS4MNqCA7qq5PVeiKBlNiI3GFYZoI7UhE";
    
    /** @test */
    public function update_line_without_token_middleware_error()
    {
        $response = $this->putJson('/api/v1/lines/3',[]);

        $response->assertStatus(401);
        $response->assertJsonStructure(['message','code']);
        $response->assertJson([
            'message' => 'Token de autenticación invalido',
            'code' => 'invalid_token'
        ]);
    }

    /** @test */
    public function update_line_return_request_validation_messages()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson('/api/v1/lines/3',[]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message','errors']);
        $response->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function update_line_return_invalid_line_id()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson('/api/v1/lines/100',[
            "name" => "línea modificada",
            "description" => "Descripción de la línea modificada"
        ]);

        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);
        $response->assertJsonMissingValidationErrors(["message" => "No query results for model [App\\Models\\Line] 100"]);
    }

    /** @test */
    public function update_line_return_correct_response()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson('/api/v1/lines/3',[
            "name" => "línea modificada 1",
            "description" => "Descripción de la línea modificada",
            "group_id" => "1"
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['line','message']);
        $response->assertJson(['message' => 'Información de linea de investigación actualizada con éxito']);
    }
}
