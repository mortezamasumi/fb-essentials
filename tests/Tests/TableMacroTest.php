<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Mortezamasumi\FbEssentials\Facades\FbPersian;
use Mortezamasumi\FbEssentials\Tests\Services\Post;
use Mortezamasumi\FbEssentials\Tests\Services\PostsTable;

it('can render post lists page', function () {
    $this
        ->livewire(PostsTable::class)
        ->assertSuccessful();
});

it('can render list of posts', function () {
    $posts = Post::factory()->count(10)->create();

    $this
        ->livewire(PostsTable::class)
        ->assertCanSeeTableRecords($posts)
        ->assertCountTableRecords(10);
});

it('can test table column macros', function () {
    App::setLocale('fa');

    $post = Post::factory()->create();

    $content = $this
        ->livewire(PostsTable::class)
        ->html();

    expect(Str::containsAll($content, [
        FbPersian::digit($post->title1),
        $post->title2,
        FbPersian::jDateTime(__('fb-essentials::fb-essentials.date_format.simple'), $post->date1),
        FbPersian::jDateTime(__('fb-essentials::fb-essentials.date_format.time_simple'), $post->date2),
    ]))->toBeTrue();

    expect($content)->not->toContain($post->title1);
});
