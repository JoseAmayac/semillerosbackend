<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerLogoutTest extends TestCase
{
    /** @test */
    public function logout_without_token()
    {
        $response = $this->getJson('/api/auth/logout');

        $response->assertStatus(401);
        $response->assertJsonStructure(['message','code']);
        $response->assertJson([
            'message' => 'Token de autenticación invalido',
            'code' => 'invalid_token'
        ]);
    }

    /** @test */
    public function logout_with_valid_token_and_response()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiODU0NWIwYzJhNTZjYTI0YjQ5N2I1MTVjNDM1YWQ4Njk0ZDBmMTIyNzZhYTM5ZjdlZjEzNmZmMWUxMTg5M2E3YmU2N2E3M2Q1MTEyYjU0OGMiLCJpYXQiOjE2MDYxODE4ODcsIm5iZiI6MTYwNjE4MTg4NywiZXhwIjoxNjA2MjY4Mjg3LCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.PC1QenIWuNO37MmCT8k0CRNqLauIt7FBwfalth2i3626llSzZsbRdhs9VAFpnUHZHpQixVzeX0W1C5cvGIQF48GmkLl6doHxCrqubaxMJDzpt_aIwx6RwqH9YM9969epmgr1fc716XudRPkXa2dJBCDzEUBSREerqGPzLc1GSFZX3k18KjNmwdlWhJt7-vZdFs8ZlG6ihUN5ucDYXTowoPnYYM57Xz1GVrFj1pZjihKtv6Vjx65uH_J8mIcRntX3HNDe1WZERlqzZlP1RFvI-qlFYWfWjtO-go2yO51k6C4LKEmdbUGrKhiMNNXl6KBJh_PtQqsUmjPNCwMgduSIC7pBGQuohaRlsk9vBlgkLXa5Xhv33UZuDwfkKd3vqM9dQL-ZHPQ_4RnzoIoc3erka4SoOVJKldUW6KEK6Yls6wIEWQ9wGAG79rmwMlfj9uW2l0lmvbpNH2LUQPWyRhM9wuTSqiBx96ZIUVNjDLaNQDrvP7Orb3auvOmImirDuaXzJBatkdMgaYb2OLj4eXjR8qI6qGb4kYkJMMHKKpIV5sU6h_pe7QsbFdfJHUx9R_6uLfewB5FMvQsmYOsWpiYfB4Ll8rb7xk5CtZcNIo0fvXPOV8Fx1LXqfolHz81SJ7W2X9vs3phjtqdq8Y7UW_az_2fnRDM0-zSl3asrX8DKy30'
        ])->getJson('/api/auth/logout');

        $response->assertStatus(203);
        $response->assertJsonStructure(['message']);
        $response->assertJson([
            'message' => 'Cierre se sesión correcto'
        ]);
    }
}
