<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicationControllerStoreTest extends TestCase
{
    private $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiY2NjMGEzYjU0NDc4YTkxYWNhNDM1OTUzMzkxMjU1ZWU0NjNhYzNjMzQ3MTljZTFhNTgzMTE4Yzk0NTNlZTljMzY3MTJkM2ZmNDY4YWQ3ODIiLCJpYXQiOjE2MDYyNjQ1NDMsIm5iZiI6MTYwNjI2NDU0MywiZXhwIjoxNjA2MzUwOTQzLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.hygWS4qxWFY6L0nSDeBDIjNwc3X1jUxqyboxg4hMMzbCZQC6j8LffzEKwCyB2XyrGqgKCsmJcdztDiwaduXXkHDG4rmbVnDhjFvkdWknQorfaNwwWGkjBV18DpmAfhoVryyZKyL_xQ-O4KF7dUUN9kuuvBZpGLmU42WmV66WcNZ6MBTxmHlq6mRQgnbrQmr2c0Iq02zfOrdjtiWPmudp03fP3iX39CD1jOSuL7Il22ZpP8KEquLaJMOJsDM-A3huSOu7-dtibCVn05Elhz5pkwLbV7hbAtM7hUTw4KlLbsv7ViS02_gaXLpNfuYjzyrC5v5bNoh-Q169cj5ppto7rmkmFzXlBbxdIvOP-cf5ye8kCHxT-FuZLbhSQrrWuGryK-FuEf1zEmCRBt6wbIsBrH65NPI6ipBZWumG73yaSQQ-pR2FJFUbzAEjiv-rTI9iFXuXQwA_tj9--hneFcl-jgcdZOklhkqxH0ve6zXu8ifOEF-EscL5xXN91bw99bprjidO7_FBYtJEIDXpPuimOGQlzQTNgJTnJ7TP4WHUuCMvXV-hAvLVoUl8aRrlgFYlVuJdhpnuZSuOkiO3tSvtOD-sEHpP4ecNuBvqe71X9L70C4Rz5L7QHvM9I987RcntPXEFcYdIADpS4MNqCA7qq5PVeiKBlNiI3GFYZoI7UhE";
    /** @test */
    public function store_return_validation_request_messages()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->postJson('/api/v1/publications',[]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message','errors']);
        $response->assertJsonValidationErrors(['references', 'link', 'group_id', 'user_id']);
    }

    /** @test */
    public function store_return_correct_response_after_save()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->postJson('/api/v1/publications',[
            "references" => "Orozco-Arias, S., Núñez-Rincón, A. M., Tabares-Soto, R., & López-Álvarez, D. (2019). Worldwide co-occurrence analysis of 17 species of the genus Brachypodium using data mining. PeerJ, 6, e6193",
            "link" => "https://peerj.com/articles/6193/",
            "group_id" => "1",
            "user_id" => "4"
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['publication']);
    }

    /** @test */
    public function store_without_token_in_headers_middleware_error()
    {
        $response = $this->postJson('/api/v1/publications',[
            "references" => "Orozco-Arias, S., Núñez-Rincón, A. M., Tabares-Soto, R., & López-Álvarez, D. (2019). Worldwide co-occurrence analysis of 17 species of the genus Brachypodium using data mining. PeerJ, 6, e6193",
            "link" => "https://peerj.com/articles/6193/",
            "group_id" => "1",
            "user_id" => "4"
        ]);

        $response->assertStatus(401);
        $response->assertJsonStructure(['message','code']);
        $response->assertJson([
            'message' => 'Token de autenticación invalido',
            'code' => 'invalid_token'
        ]);
    }
}
