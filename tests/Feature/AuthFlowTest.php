<?php

use App\Models\BlockIP;
use App\Models\User;

test('login and register pages load', function () {
    $this->get('/login')->assertOk();
    $this->get('/register')->assertOk();
});

test('a user can register and is redirected to dashboard', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticated();
});

test('a user can login and logout', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'password123',
    ])->assertRedirect('/dashboard');

    $this->assertAuthenticated();

    $this->post('/logout')->assertRedirect('/login');
    $this->assertGuest();
});

test('blocked ip cannot login', function () {
    BlockIP::query()->create([
        'ip_address' => '1.2.3.4',
        'blocked_at' => now(),
        'reason' => 'blocked',
    ]);

    User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $this->withServerVariables(['REMOTE_ADDR' => '1.2.3.4'])
        ->from('/login')
        ->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ])
        ->assertRedirect('/login')
        ->assertSessionHasErrors('email');
});
