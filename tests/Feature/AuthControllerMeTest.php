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
            'Authorization' => 'Bearer yJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDAyZGMwYjlkYzQzY2RkYWM5MTM2NzZmNTRmYmI4MzRiMWM1MDkwNWRjZDQ5YTY3YmQ4NWE2MDc1OTViYTg2YjY5NmQyNTc4ZmM5MTgxZWYiLCJpYXQiOjE2MDYwNzIyMDAsIm5iZiI6MTYwNjA3MjIwMCwiZXhwIjoxNjA2MTU4NTk5LCJzdWIiOiI5Iiwic2NvcGVzIjpbIioiXX0.klDDTt8kiz1ePQxyZu9RZTfLC_9hQmBHGTwM_tqH3fdXJItdfHKXgmV_ksOWd4pFqpDORleWo_ibm8Y9B7bUEbyVu1LCRK5BZCd5442EOrQFz-Wxjg6rNTDs4f_dH32oEOpnFirBT9MbnziNxwjGmHdwaCfBJZQbhNY6Qf3uJY22uqX8Ut6-HKaH9SXw6pDYJUlBT-nc6Y7M43MJKCeMltr66V0kzaE2Ewwg3I_xYXIqPOanXHSZE1Z3SEzETXtRqi_fbf9gOLOQlabNtcUiOQTU2tBwTceoLIGT0kYtiALOTZoZer7A0CZKmksNJRSf_ofIOTRoHQ3f95SSRPN1VRuqD4l5tCtiqti-2sNYYFwA0mgSOkLzvpZL7HEAmdzbeS3HXb7SsH7HL676ZNbhDT3LnCr46LdoCWQCebbZsPztrXu9seRJglK0zZJZGGn8DIqv5dBFCxbG6iJRMdjukCEw-liNv8_HbjMZN-y-2hL5QFjGfbLnGQKq8rL5eKSE792bU6XZshXUcCFyxWFSvP1628LsQT59pCCKcuteImUV3Krk-x-nSzRmsBNyUqSZTn0raZImoaoltP87CBf8zmUqg1_JAKwHtQsvW2U8SglwjHIgUow7w-agMd5tjGiLs9H409QE2TAykNpEkMdhgMHVTGJ_QMfHaT4lVhjGf8c'
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
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZjVkNmI3ZThiM2Y1ZWU2YzNjMWI5MDU3NjZkOTQ2NGUzYzVhMzY5OGY2MWZkOTY4MjA2ZThiOTcyODk3NjViZjYxMzcyMDA5ODQ3MjAwN2EiLCJpYXQiOjE2MDYxODA4NjMsIm5iZiI6MTYwNjE4MDg2MywiZXhwIjoxNjA2MjY3MjYzLCJzdWIiOiIyIiwic2NvcGVzIjpbIioiXX0.n-fIkPXH_ujgE0TWzew_DTfV32e_PAiIEyMHnW5-gHifNY_P4JAbcA6qj_lB5ov4RmJgr9GtKwBod0antLz29kYSfSGGsV1Ujh-44AdWMCAqnB3YnceN3s68qGjudSDtALflkNRo4_f0mvpb1T7evXFfAmx1YUz7MUNWok32TD46EpRspaDyYIl7TMUPdhxjG9sn1vbYIB-NEJkXvypsY3myvSCSbt9AMRKXcSLe59vYneK80CzpGokopR0mneIrydpDbIsSbYeOsawcikydbj0cghwg_Fd68Bq7RhZSl-4qpN64kDUBLu4-V7_MDK2KrpYyi4OQCjFChEDB0Hkccx63siktJKSMVSMiq4f2QOB3KJx3gfvB7USN_rdwvOpT2EUY19_adtglILLzMK9VFfSKoqz893Zav2H7Y-Kf4fRt4UvguBHWGDMlSeetVnp9yc-AFOhJPrju6yv56PMh8U4xJXJq8fhDGWEbJL-2m2EQrirtS76yhm_7zZad1h2dCZXHP6HFE-9q17KfW9G3jr-fmub5qcm8v9VGuHp47Dy4y9zwkhFidTonSlQQIOxsuVSJcAEw6m0PsXI8H46woE5RyQs9Cs78A-61QDYBmNcE7vcH6dPk2os09o-XWG2goWVVAExms_DVo9dXWmok_T8Ul8DfA0hMBgOuFZ4FRFc'
        ])->getJson('/api/auth/me');

        $response->assertStatus(200);
        $response->assertJsonStructure(['user']);
    }
}
