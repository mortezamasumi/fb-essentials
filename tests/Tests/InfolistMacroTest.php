<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Mortezamasumi\FbEssentials\Tests\Services\Post;
use Mortezamasumi\FbEssentials\Tests\Services\PostView;

it('can render post infolist page', function () {
    $this
        ->livewire(PostView::class)
        ->assertSuccessful();
});

it('check that infolist page contains correct info', function () {
    App::setLocale('fa');

    $post = Post::factory()->create([
        'title1' => '1234',
        'title2' => '4321',
        'date1' => Carbon::parse('2017-12-13 11:22:33'),
        'date2' => Carbon::parse('2017-12-14 11:22:33'),
    ]);

    $this
        ->livewire(PostView::class, ['post' => $post])
        ->assertSee('۱۲۳۴')
        ->assertSee('4321')
        ->assertSee('۱۳۹۶/۰۹/۲۲')
        ->assertDontSee('۱۳۹۶/۰۹/۲۲ ۱۱:۲۲:۳۳')
        ->assertDontSee('۱۳۹۶/۰۹/۲۳ ۱۱:۲۲:۳۳');
});
