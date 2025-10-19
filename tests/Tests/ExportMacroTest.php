<?php

use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mortezamasumi\FbEssentials\Facades\FbPersian;
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

it('can export posts and verify downloaded csv file', function () {
    Post::factory(20)->create();

    $this
        ->actingAs(User::factory()->create())
        ->livewire(PostsExport::class)
        ->mountAction('export')
        ->callMountedAction()
        ->assertNotified();

    $export = Export::first();

    expect($export)->not->toBeNull();
    expect($export->processed_rows)->toBe(20);
    expect($export->successful_rows)->toBe(20);
    expect($export->completed_at)->not->toBeNull();

    $content = $this
        ->get(route(
            'filament.exports.download',
            ['export' => $export, 'format' => 'csv'],
            absolute: false
        ))
        ->assertDownload()
        ->streamedContent();

    expect($content)
        ->toContain('Title1,Title2,Date1,Date2');

    expect(Str::containsAll($content, Post::all()->pluck('title1')))->toBeTrue();
});

it('can test export column macros', function () {
    App::setLocale('fa');

    $post = Post::factory()->create();

    $this
        ->actingAs(User::factory()->create())
        ->livewire(PostsExport::class)
        ->mountAction('export')
        ->callMountedAction()
        ->assertNotified();

    $content = $this
        ->get(route(
            'filament.exports.download',
            ['export' => Export::first(), 'format' => 'csv'],
            absolute: false
        ))
        ->assertDownload()
        ->streamedContent();

    expect(Str::containsAll($content, [
        FbPersian::digit($post->title1),
        $post->title2,
        FbPersian::jDateTime(__('fb-essentials::fb-essentials.date_format.simple'), $post->date1),
        FbPersian::jDateTime(__('fb-essentials::fb-essentials.date_format.time_simple'), $post->date2),
    ]))->toBeTrue();

    expect($content)->not->toContain($post->title1);
});
