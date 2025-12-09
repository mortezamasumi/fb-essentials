<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Mortezamasumi\FbEssentials\Tests\Services\Post;
use Mortezamasumi\FbEssentials\Tests\Services\PostView;

it('check that infolist page contains correct info', function () {
    App::setLocale('fa');

    $post = Post::factory()->create([
        'title1' => '1234',
        'title2' => '4321',
        'date1' => Carbon::parse('2017-12-13 11:22:33'),
        'date2' => Carbon::parse('2017-12-14 11:22:33'),
    ]);

    /** @var Pest $this */
    $this
        ->livewire(PostView::class, ['record' => $post])
        ->assertSuccessful()
        ->assertSchemaStateSet([
            'title1' => $post->title1,
            'title2' => $post->title2,
            'date1' => $post->date1,
            'date2' => $post->date2,
        ])
        ->assertSee(__digit($post->title1))
        ->assertSee($post->title2)
        ->assertSee(__jdatetime(__f_date(), $post->date1))
        ->assertDontSee(__jdatetime(__f_datetime(), $post->date1))
        ->assertSee(__jdatetime(__f_datetime(), $post->date2));
});
