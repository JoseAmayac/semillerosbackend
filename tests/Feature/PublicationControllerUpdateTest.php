<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicationControllerUpdateTest extends TestCase
{
    use DatabaseTransactions;
    private $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiY2NjMGEzYjU0NDc4YTkxYWNhNDM1OTUzMzkxMjU1ZWU0NjNhYzNjMzQ3MTljZTFhNTgzMTE4Yzk0NTNlZTljMzY3MTJkM2ZmNDY4YWQ3ODIiLCJpYXQiOjE2MDYyNjQ1NDMsIm5iZiI6MTYwNjI2NDU0MywiZXhwIjoxNjA2MzUwOTQzLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.hygWS4qxWFY6L0nSDeBDIjNwc3X1jUxqyboxg4hMMzbCZQC6j8LffzEKwCyB2XyrGqgKCsmJcdztDiwaduXXkHDG4rmbVnDhjFvkdWknQorfaNwwWGkjBV18DpmAfhoVryyZKyL_xQ-O4KF7dUUN9kuuvBZpGLmU42WmV66WcNZ6MBTxmHlq6mRQgnbrQmr2c0Iq02zfOrdjtiWPmudp03fP3iX39CD1jOSuL7Il22ZpP8KEquLaJMOJsDM-A3huSOu7-dtibCVn05Elhz5pkwLbV7hbAtM7hUTw4KlLbsv7ViS02_gaXLpNfuYjzyrC5v5bNoh-Q169cj5ppto7rmkmFzXlBbxdIvOP-cf5ye8kCHxT-FuZLbhSQrrWuGryK-FuEf1zEmCRBt6wbIsBrH65NPI6ipBZWumG73yaSQQ-pR2FJFUbzAEjiv-rTI9iFXuXQwA_tj9--hneFcl-jgcdZOklhkqxH0ve6zXu8ifOEF-EscL5xXN91bw99bprjidO7_FBYtJEIDXpPuimOGQlzQTNgJTnJ7TP4WHUuCMvXV-hAvLVoUl8aRrlgFYlVuJdhpnuZSuOkiO3tSvtOD-sEHpP4ecNuBvqe71X9L70C4Rz5L7QHvM9I987RcntPXEFcYdIADpS4MNqCA7qq5PVeiKBlNiI3GFYZoI7UhE";
    
    /** @test */
    public function update_publication_without_token_middleware_error()
    {
        $response = $this->putJson('/api/v1/publications/3',[]);

        $response->assertStatus(401);
        $response->assertJsonStructure(['message','code']);
        $response->assertJson([
            'message' => 'Token de autenticación invalido',
            'code' => 'invalid_token'
        ]);
    }

    /** @test */
    public function update_publication_return_request_validation_messages()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson('/api/v1/publications/3',[]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message','errors']);
        $response->assertJsonValidationErrors(['references', 'link', 'group_id', 'user_id']);
    }

    /** @test */
    public function update_publication_return_invalid_line_id()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson('/api/v1/publications/100',[
            "references" => "Orozco-Arias, S., Núñez-Rincón, A. M., Tabares-Soto, R., & López-Álvarez, D. (2019). Worldwide co-occurrence analysis of 17 species of the genus Brachypodium using data mining. PeerJ, 6, e6193",
            "link" => "https://peerj.com/articles/6193/",
            "group_id" => "1",
            "user_id" => "4"
        ]);

        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);
        $response->assertJsonMissingValidationErrors(["message" => "No query results for model [App\\Models\\Publication] 100"]);
    }

    /** @test */
    public function update_publication_return_correct_response()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson('/api/v1/publications/3',[
            "references" => "Orozco-Arias, S., Núñez-Rincón, A. M., Tabares-Soto, R., & López-Álvarez, D. (2019). Worldwide co-occurrence analysis of 17 species of the genus Brachypodium using data mining. PeerJ, 6, e6193",
            "link" => "https://peerj.com/articles/6193/",
            "group_id" => "1",
            "user_id" => "4"
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['publication','message']);
        $response->assertJson(['message' => 'Información de publicación actualizada correctamente']);
    }
}
