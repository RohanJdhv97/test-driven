<?php

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use function Pest\Livewire\livewire;

it('can render user resource page', function () {
    parent::setUp();

    $this->actingAs(User::factory()->create());

    livewire(ListUsers::class)->assertSuccessful();
});

it('can render user create page', function () {
    livewire(CreateUser::class)->assertSuccessful();
});

it('new user creations', function () {
    $newUser = User::factory()->make();

    livewire(CreateUser::class)
        ->fillForm([
            'name' => $newUser->name,
            'email' => $newUser->email,
        ])
        ->call('create')
        ->assertHasNoErrors();
    $this->assertDatabaseHas(User::class, [
        'name' => $newUser->name,
        'email' => $newUser->email,
    ]);
});
