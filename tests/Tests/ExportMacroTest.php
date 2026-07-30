<?php

use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Facades\App;
use Mortezamasumi\FbEssentials\Tests\Services\Post;
use Mortezamasumi\FbEssentials\Tests\Services\PostsExport;
use Mortezamasumi\FbEssentials\Tests\Services\User;

it('can render export page', function () {
    $this
        ->livewire(PostsExport::class)
        ->assertSuccessful();
});

it('can see export action', function () {
    $this
        ->livewire(PostsExport::class)
        ->assertActionExists('export');
});

it('can call export action', function () {
    $this
        ->actingAs(User::factory()->create())
        ->livewire(PostsExport::class)
        ->mountAction('export')
        ->callMountedAction()
        ->assertHasNoActionErrors();
});

it('can export posts with jDate and localeDigit macros', function () {
    App::setLocale('fa');

    $count = 3;

    Post::factory($count)->create();

    $this
        ->actingAs(User::factory()->create())
        ->livewire(PostsExport::class)
        ->mountAction('export')
        ->callMountedAction()
        ->assertHasNoActionErrors();

    $export = Export::latest()->first();

    expect($export)
        ->not
        ->toBeNull()
        ->processed_rows
        ->toBe($count)
        ->successful_rows
        ->toBe($count)
        ->completed_at
        ->not
        ->toBeNull();
});
