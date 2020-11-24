<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerRegisterTest extends TestCase
{
    // use RefreshDatabase;
    /** @test */
    public function register_return_validation_errors_messages()
    {
        $response = $this->postJson('api/auth/signup',[
            'name' => 'prueba',
            'lastname' => 'primera',
            'email' => 'prueba@gmail.com',
            'password' => '',
            'password_confirmation' => '',
            'cellphone' => '',
            'program_id' => ''
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password','cellphone','program_id']);
    }

    /** @test */
    // public function register_without_programs(){
    //     $response = $this->postJson('api/auth/signup',[
    //         'name' => 'prueba',
    //         'lastname' => 'primera',
    //         'email' => 'admin@gmail.com',
    //         'password' => '12345678',
    //         'password_confirmation' => '12345678',
    //         'cellphone' => '3202536253',
    //         'program_id' => '1'
    //     ]);
        
    //     $this->assertDatabaseCount('programs',0);
    //     $response->assertStatus(422);
    // }

    /** @test */
    public function register_with_email_that_exists(){
        $response = $this->postJson('api/auth/signup',[
            'name' => 'prueba',
            'lastname' => 'primera',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'cellphone' => '3202536253',
            'program_id' => '1'
        ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
        $response->assertJsonStructure(['errors']);
    }

    /** @test */
    public function register_return_authaccess_credentials(){
        $response = $this->postJson('api/auth/signup',[
            'name' => 'prueba',
            'lastname' => 'primera',
            'email' => 'pruebaprimera1@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'cellphone' => '3202536253',
            'program_id' => 1
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['authaccess','user']);
    }
}
