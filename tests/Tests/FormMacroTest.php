<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Mortezamasumi\FbEssentials\Tests\Services\Post;
use Mortezamasumi\FbEssentials\Tests\Services\PostCreate;

it('can render post form', function () {
    /** @var Pest $this */
    $this
        ->livewire(PostCreate::class)
        ->assertSuccessful();
});

it('can call create method', function () {
    App::setLocale('fa');

    /** @var Pest $this */
    $this
        ->livewire(PostCreate::class)
        ->fillForm([
            'title1' => '۱۲۳۴',
            'title2' => '1234',
            'date1' => '2017-12-13 11:22:33',
            'date2' => '2017-12-14 11:22:33',
        ])
        ->call('create')
        ->assertHasNoErrors();
});

it('can fill the form and store it correctly', function () {
    App::setLocale('fa');

    /** @var Pest $this */
    $this
        ->livewire(PostCreate::class)
        ->fillForm([
            'title1' => '۱۲۳۴',
            'title2' => '1234',
            'date1' => '2017-12-13 11:22:33',
            'date2' => '2017-12-14 11:22:33',
        ])
        ->call('create');

    expect(Post::first())
        ->toMatchArray([
            'title1' => '1234',
            'title2' => '۱۲۳۴',
            'date1' => Carbon::parse('2017-12-13')->toIsoString(),
            'date2' => Carbon::parse('2017-12-14 11:22:33')->toIsoString(),
        ]);
});
