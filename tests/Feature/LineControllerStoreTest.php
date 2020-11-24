<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LineControllerStoreTest extends TestCase
{
    private $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZjVkNmI3ZThiM2Y1ZWU2YzNjMWI5MDU3NjZkOTQ2NGUzYzVhMzY5OGY2MWZkOTY4MjA2ZThiOTcyODk3NjViZjYxMzcyMDA5ODQ3MjAwN2EiLCJpYXQiOjE2MDYxODA4NjMsIm5iZiI6MTYwNjE4MDg2MywiZXhwIjoxNjA2MjY3MjYzLCJzdWIiOiIyIiwic2NvcGVzIjpbIioiXX0.n-fIkPXH_ujgE0TWzew_DTfV32e_PAiIEyMHnW5-gHifNY_P4JAbcA6qj_lB5ov4RmJgr9GtKwBod0antLz29kYSfSGGsV1Ujh-44AdWMCAqnB3YnceN3s68qGjudSDtALflkNRo4_f0mvpb1T7evXFfAmx1YUz7MUNWok32TD46EpRspaDyYIl7TMUPdhxjG9sn1vbYIB-NEJkXvypsY3myvSCSbt9AMRKXcSLe59vYneK80CzpGokopR0mneIrydpDbIsSbYeOsawcikydbj0cghwg_Fd68Bq7RhZSl-4qpN64kDUBLu4-V7_MDK2KrpYyi4OQCjFChEDB0Hkccx63siktJKSMVSMiq4f2QOB3KJx3gfvB7USN_rdwvOpT2EUY19_adtglILLzMK9VFfSKoqz893Zav2H7Y-Kf4fRt4UvguBHWGDMlSeetVnp9yc-AFOhJPrju6yv56PMh8U4xJXJq8fhDGWEbJL-2m2EQrirtS76yhm_7zZad1h2dCZXHP6HFE-9q17KfW9G3jr-fmub5qcm8v9VGuHp47Dy4y9zwkhFidTonSlQQIOxsuVSJcAEw6m0PsXI8H46woE5RyQs9Cs78A-61QDYBmNcE7vcH6dPk2os09o-XWG2goWVVAExms_DVo9dXWmok_T8Ul8DfA0hMBgOuFZ4FRFc";
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->postJson('/api/v1/lines',[]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message','errors']);
        $response->assertJsonValidationErrors(['name, group_id']);
    }
}
