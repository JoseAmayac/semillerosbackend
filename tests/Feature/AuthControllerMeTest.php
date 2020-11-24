<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerMeTest extends TestCase
{
    /** @test */
    public function get_logged_user_without_token()
    {
        $response = $this->getJson('/api/auth/me');

        $response->assertStatus(401);
        $response->assertJsonStructure(['message','code']);
    }

    /** @test */
    public function get_logged_user_with_expired_token(){
        $response = $this->withHeaders([
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDAyZGMwYjlkYzQzY2RkYWM5MTM2NzZmNTRmYmI4MzRiMWM1MDkwNWRjZDQ5YTY3YmQ4NWE2MDc1OTViYTg2YjY5NmQyNTc4ZmM5MTgxZWYiLCJpYXQiOjE2MDYwNzIyMDAsIm5iZiI6MTYwNjA3MjIwMCwiZXhwIjoxNjA2MTU4NTk5LCJzdWIiOiI5Iiwic2NvcGVzIjpbIioiXX0.klDDTt8kiz1ePQxyZu9RZTfLC_9hQmBHGTwM_tqH3fdXJItdfHKXgmV_ksOWd4pFqpDORleWo_ibm8Y9B7bUEbyVu1LCRK5BZCd5442EOrQFz-Wxjg6rNTDs4f_dH32oEOpnFirBT9MbnziNxwjGmHdwaCfBJZQbhNY6Qf3uJY22uqX8Ut6-HKaH9SXw6pDYJUlBT-nc6Y7M43MJKCeMltr66V0kzaE2Ewwg3I_xYXIqPOanXHSZE1Z3SEzETXtRqi_fbf9gOLOQlabNtcUiOQTU2tBwTceoLIGT0kYtiALOTZoZer7A0CZKmksNJRSf_ofIOTRoHQ3f95SSRPN1VRuqD4l5tCtiqti-2sNYYFwA0mgSOkLzvpZL7HEAmdzbeS3HXb7SsH7HL676ZNbhDT3LnCr46LdoCWQCebbZsPztrXu9seRJglK0zZJZGGn8DIqv5dBFCxbG6iJRMdjukCEw-liNv8_HbjMZN-y-2hL5QFjGfbLnGQKq8rL5eKSE792bU6XZshXUcCFyxWFSvP1628LsQT59pCCKcuteImUV3Krk-x-nSzRmsBNyUqSZTn0raZImoaoltP87CBf8zmUqg1_JAKwHtQsvW2U8SglwjHIgUow7w-agMd5tjGiLs9H409QE2TAykNpEkMdhgMHVTGJ_QMfHaT4lVhjGf8c'
        ])->getJson('/api/auth/me');

        $response->assertStatus(401);
        $response->assertJsonStructure(['message','code']);
        $response->assertJson([
            'message' => 'El token de autenticación expiró',
            'code' => 'token_expired'
        ]);
    }

    /** @test */
    public function get_logged_user_with_invalid_token(){
        $response = $this->withHeaders([
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDAyZGMwYjlkYzQzY2RkYWM5MTM2NzZmNTRmYmI4MzRiMWM1MDkwNWRjZDQ5YTY3YmQ4NWE2MDc1OTViYTg2YjY5NmQyNTc4ZmM5MTgxZWYiLCJpYXQiOjE2MDYwNzIyMDAsIm5iZiI6MTYwNjA3MjIwMCwiZXhwIjoxNjA2MTU4NTk5LCJzdWIiOiI5Iiwic2NvcGVzIjpbIioiXX0.klDDTt8kiz1ePQxyZu9RZTfLC_9hQmBHGTwM_tqH3fdXJItdfHKXgmV_ksOWd4pFqpDORleWo_ibm8Y9B7bUEbyVu1LCRK5BZCd5442EOrQFz-Wxjg6rNTDs4f_dH32oEOpnFirBT9MbnziNxwjGmHdwaCfBJZQbhNY6Qf3uJY22uqX8Ut6-HKaH9SXw6pDYJUlBT-nc6Y7M43MJKCeMltr66V0kzaE2Ewwg3I_xYXIqPOanXHSZE1Z3SEzETXtRqi_fbf9gOLOQlabNtcUiOQTU2tBwTceoLIGT0kYtiALOTZoZer7A0CZKmksNJRSf_ofIOTRoHQ3f95SSRPN1VRuqD4l5tCtiqti-2sNYYFwA0mgSOkLzvpZL7HEAmdzbeS3HXb7SsH7HL676ZNbhDT3LnCr46LdoCWQCebbZsPztrXu9seRJglK0zZJZGGn8DIqv5dBFCxbG6iJRMdjukCEw-liNv8_HbjMZN-y-2hL5QFjGfbLnGQKq8rL5eKSE792bU6XZshXUcCFyxWFSvP1628LsQT59pCCKcuteImUV3Krk-x-nSzRmsBNyUqSZTn0raZImoaoltP87CBf8zmUqg1_JAKwHtQsvW2U8SglwjHIgUow7w-agMd5tjGiLs9H409QE2TAykNpEkMdhgMHVTGJ_QMfHaT4lVhjGf8c'
        ])->getJson('/api/auth/me');

        $response->assertStatus(401);
        $response->assertJsonStructure(['message','code']);
        $response->assertJson([
            'message' => 'Token de autenticación invalido',
            'code' => 'invalid_token'
        ]);
    }

    /** @test */
    public function get_logged_user_information(){
        $response = $this->withHeaders([
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiM2I4ZTM1MmNjZWJhMjFhZWRiYWFmMmYxMDQ0NGUyM2Y3OWE0NDE0ODM5ZTMyOWQ0OGY3MmRlZGIxN2YwOThjMTZkMDczNjUzZDczMjUxOWYiLCJpYXQiOjE2MDYxODEzNTgsIm5iZiI6MTYwNjE4MTM1OCwiZXhwIjoxNjA2MjY3NzU4LCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.fWVnDUC7mHNhQQ_HzrFF-NDHN2WEpboB33AtCXV-rNBfp_RqTANtHBfhqin3dr9pN6xAzI8EysOOYRWw8ebd6JMqFJV2ytq2nN33d_NiEmZZNSqlD8Sd2DfZEdRGOy9rtZo-VuvU_myH0qKOwqPkUgpic2UpMgIFakRL4_UP96SBGlYPMIcANiPH4RQrmvRU8N3Z27pxL0VzQdaHLyKyJx7jIiVJPWRV5QYitA5k9jm9Mz126Bsv-sJmsTpw4Veff7sT_J0d7My4GdLM82CDK_4T0MAmcFnzr5CPmVXi8LDQfYEgXCMmb9sAm2lxY78YK3b5gQj2UFrNoS3a9AJjww-SlvkDjz-4K3mjL1pfeA2X9iVON-o4QA5me5OhQDv4TxtGEJz0Bsnq_wiubffQM6PraFIuoEy5sGZ7oOI7oRY_uPPMnC43RU1TzvWDP2SmCy74gODoTyQwLVZK-SHFP0zgp-g0ST4mUXJbm2MhCtmTuM5OcUhvWaDPpozrgqN7OwiqIFwfHpsl0r1w0wk7hTv7kAQXosrSHQu5SMooLCzjz6wJCSusxHMIJe2N_h97vbiH2ztIVDPBTrB9B-gcIfdH5kWtsULkXS-ynceRr-T2sC2yQm7MvnUFQDJFrs6yykcvmBqh9qosmmnIrIN_sA_5DkdChlF-XFg61oNk3hw'
        ])->getJson('/api/auth/me');

        $response->assertStatus(200);
        $response->assertJsonStructure(['user']);
    }
}
