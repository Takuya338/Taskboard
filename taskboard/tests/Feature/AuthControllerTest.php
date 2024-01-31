<?php

namespace Tests\Feature;

use App\Services\LoginService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowLogin()
    {
        $response = $this->get('/'); // ここにログイン画面のURLを指定
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }
    
    /*public function testSuccessfulLogin()
    {
        // LoginServiceのモックを作成して、常にtrueを返すように設定
        $this->mock(LoginService::class, function ($mock) {
            $mock->shouldReceive('login')->andReturn(true);
        });

        $response = $this->post('/login', [
            'email' => 'alice@example.com',
            'password' => 'password',
        ]);

        // リダイレクトの検証
        $response->assertRedirect('/taskboards');
    }*/


    /*public function testLogout()
    {
        // LoginServiceのモックを作成
        $this->mock(LoginService::class, function ($mock) {
            $mock->shouldReceive('logout')->once();
        });

        $response = $this->get('/logout'); // ここにログアウト処理のURLを指定

        $response->assertRedirect('/'); // リダイレクト先を検証
    }*/
}

