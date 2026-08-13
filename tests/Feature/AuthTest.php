<?php

use App\Models\User;
use App\Models\Resume;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest can view login and register pages', function () {
    $this->get(route('login'))->assertOk();
    $this->get(route('register'))->assertOk();
});

test('guest can register with valid parameters and is logged in', function () {
    $response = $this->post(route('register'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
});

test('guest cannot register with invalid parameters', function () {
    $response = $this->post(route('register'), [
        'name' => '',
        'email' => 'not-an-email',
        'password' => '123',
        'password_confirmation' => 'abc',
    ]);

    $response->assertSessionHasErrors(['name', 'email', 'password']);
    $this->assertGuest();
});

test('guest can login with correct credentials', function () {
    $user = User::factory()->create([
        'email' => 'user@example.com',
        'password' => bcrypt('secret-password'),
    ]);

    $response = $this->post(route('login'), [
        'email' => 'user@example.com',
        'password' => 'secret-password',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticatedAs($user);
});

test('guest cannot login with incorrect credentials', function () {
    User::factory()->create([
        'email' => 'user@example.com',
        'password' => bcrypt('secret-password'),
    ]);

    $response = $this->post(route('login'), [
        'email' => 'user@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors(['email']);
    $this->assertGuest();
});

test('authenticated user can log out', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $response->assertRedirect(route('home'));
    $this->assertGuest();
});

test('authenticated user can only see/modify their own resumes, not others', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $resume1 = Resume::create([
        'title' => 'User 1 Resume',
        'target_profile' => 'student',
        'user_id' => $user1->id,
    ]);

    $resume2 = Resume::create([
        'title' => 'User 2 Resume',
        'target_profile' => 'student',
        'user_id' => $user2->id,
    ]);

    // User 1 logs in
    $this->actingAs($user1);

    // Can see own resume
    $this->get(route('resumes.show', $resume1->id))->assertOk();
    // Cannot see user 2's resume
    $this->get(route('resumes.show', $resume2->id))->assertForbidden();

    // Anonymous resume is accessible to all
    $anonResume = Resume::create([
        'title' => 'Anonymous Resume',
        'target_profile' => 'student',
        'user_id' => null,
    ]);
    $this->get(route('resumes.show', $anonResume->id))->assertOk();
});
