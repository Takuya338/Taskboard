<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {   // ログインページ
        $response = $this->get('/');
        $response->assertStatus(200);
        
        // ログイン機能
        //$response = $this->post('/login');
        //$response->assertStatus(200);
        
        // ログアウト機能
        //$response = $this->get('/logout');
        //$response->assertStatus(302);
    }
}
