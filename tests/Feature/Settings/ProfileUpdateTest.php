<?php

use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->user->assignRole('admin');
    $this->actingAs($this->user);
});

test('profile page is displayed', function () {
    $this->get('/settings/profile')->assertOk();
});

test('profile information can be updated', function () {
    $response = Volt::test('settings.profile')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    $this->user->refresh();

    expect($this->user->name)->toEqual('Test User');
    expect($this->user->email)->toEqual('test@example.com');
    expect($this->user->email_verified_at)->toBeNull();
});

test('email verification status is unchanged when email address is unchanged', function () {
    $response = Volt::test('settings.profile')
        ->set('name', 'Test User')
        ->set('email', $this->user->email)
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    expect($this->user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can delete their account', function () {
    $response = Volt::test('settings.delete-user-form')
        ->set('password', 'password')
        ->call('deleteUser');

    $response
        ->assertHasNoErrors()
        ->assertRedirect('/');

    expect($this->user->fresh())->toBeNull();
    expect(auth()->check())->toBeFalse();
});

test('correct password must be provided to delete account', function () {
    $response = Volt::test('settings.delete-user-form')
        ->set('password', 'wrong-password')
        ->call('deleteUser');

    $response->assertHasErrors(['password']);

    expect($this->user->fresh())->not->toBeNull();
});
