<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTestLogin extends TestCase
{
    /** @test */
    public function login_displays_validation_messages()
    {
        $response = $this->postJson('api/auth/login',[
            'email' => '',
            'password' => ''
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email','password']);
    }

    /** @test */
    public function login_displays_unauthorized_message(){
        $response = $this->postJson('api/auth/login',[
            'email' => 'admin@gmail.com',
            'password' => '123453'
        ]);
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Correo electrónico o contraseña incorrectos']);
    }
    
    /** @test */
    public function login_return_authaccess_credentials(){
        $response = $this->postJson('api/auth/login',[
            'email' => 'admin@gmail.com',
            'password' => 'adminpassword'
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['authaccess','user']);
    }
}
