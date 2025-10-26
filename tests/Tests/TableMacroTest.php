<?php

use Illuminate\Support\Facades\App;
use Mortezamasumi\FbEssentials\Facades\FbPersian;
use Mortezamasumi\FbEssentials\Tests\Services\Post;
use Mortezamasumi\FbEssentials\Tests\Services\PostsTable;

it('can render post lists page', function () {
    $this
        ->livewire(PostsTable::class)
        ->assertSuccessful();
});

it('can render list of posts', function () {
    $count = 5;
    $posts = Post::factory(5)->create();

    $this
        ->livewire(PostsTable::class)
        ->assertCanSeeTableRecords($posts)
        ->assertCountTableRecords($count);
});

it('can test table column macros', function () {
    App::setLocale('fa');

    $count = 5;
    $posts = Post::factory($count)->create();

    foreach ($posts as $post) {
        $this
            ->livewire(PostsTable::class)
            ->assertTableColumnFormattedStateSet('title1', FbPersian::digit($post->title1), record: $post)
            ->assertTableColumnFormattedStateNotSet('title1', $post->title1, record: $post)
            ->assertTableColumnFormattedStateSet('title2', $post->title2, record: $post)
            ->assertTableColumnFormattedStateSet('date1', FbPersian::jDateTime(__('fb-essentials::fb-essentials.date_format.simple'), $post->date1), record: $post)
            ->assertTableColumnFormattedStateSet('date2', FbPersian::jDateTime(__('fb-essentials::fb-essentials.date_format.time_simple'), $post->date2), record: $post);
    }
});
