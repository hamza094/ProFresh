<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_oAuth_redirect(){

        $response = $this->getJson('/api/v1/auth/redirect/github');        
        $response->assertJson([
            'redirect_url' => 'hello'
        ]);
    }
}
