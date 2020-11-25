<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerUpdatePasswordTest extends TestCase
{
    private $token = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiM2I5ZjJiNWM3ZjhiMmY0MDVhN2NkMzBjM2JkZDY5NGNlZjEyN2NhYTkzNjBmZmQwNWIyZjA4OWIwYzY3NDhkZGIyYjllODBmOGZiYjE3NDgiLCJpYXQiOjE2MDYyNzE2OTAsIm5iZiI6MTYwNjI3MTY5MCwiZXhwIjoxNjA2MzU4MDkwLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.WOnk-KyEySBPXXY43pM3o4hLeWN36psqGPnXbglR0TwgLc7_Npg9665mwExaraNqsSbe-uPgF6guoViHm0O4UJbbK_qP7i7WcSBwt8V9yB9IwiMiiw0S0aCjTHwa1LGPjOw3DE-hyk-i-CFWSVfiJ0DZiQ0Du0meMJy_fpXFGZ0oZtVS5w4PxpmXRkeCZShr17w22WY9HIeSvdid_mkzeed1xCoqe3FrJhbq9nPxPiJX4eRmgC8GezDAMCi50XmDoWV6c1KyOH2rNoWA9g-ivijxTb3GYd61c5tuwHsVIuuyRgXREbDi15DSxa8J_BHMRyE0ihtVrMzjRh5OA6-BybJbDiExKLtHeEsP_lwqzGoPJfyaOPIdg4Ew5G7FpsExqcdwVrX0BENDUoy5Do9HBJpAVjrIiGHbHpsIcKmqYY75wf5K9LkE5kmFkHrZJnfXlT7L5emaF2g_h1YlOo4uUy4tbnH3VnlsSZ_PlbcRssWTWiGMpZPZgEF3d2mf3GTR_I3mMokOESurHmUL2YELQwu9RnkwkB7iYBIsvpfou6v5H6Rl9f5ZHaZmTv4-bjlkCsgAP7hFg0B-AK8yr0dBZCOJXqw1CyYQIZZCTgl6FZpSEgQOaiJpoVp8y8oHQqZGQGgg5N2I4ZO3p59JhZ86zUNO9Cp0fCxsNNCPLOu9tfQ";
    /** @test  */
    public function update_password_request_return_validation_messages()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson('/api/v1/updatePassword',[]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message','errors']);
        $response->assertJsonValidationErrors(['password','new_password']);
    }

    /** @test */
    public function update_password_with_invalid_current_password(){
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson('/api/v1/updatePassword',[
            "password" => "123456789",
            "new_password" => "12345678",
            "new_password_confirmation" => "12345678"
        ]);

        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
        $response->assertJson(['message' => 'La contraseña actual no es correcta']);
    }

    /** @test */
    public function update_password_successfully(){
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson('/api/v1/updatePassword',[
            "password" => "adminpassword",
            "new_password" => "12345678",
            "new_password_confirmation" => "12345678"
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message','user']);
        $response->assertJson(['message' => 'Contraseña Actualizada con éxito']);
    }   

}
