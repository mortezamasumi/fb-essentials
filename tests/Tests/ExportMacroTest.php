<?php

use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Facades\App;
use Mortezamasumi\FbEssentials\Tests\Services\Post;
use Mortezamasumi\FbEssentials\Tests\Services\PostExporter;
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
    App::setLocale('fa');

    $count = 20;

    Post::factory($count)->create();

    $this
        ->actingAs(User::factory()->create())
        ->livewire(PostsExport::class)
        ->mountAction('export')
        ->callMountedAction()
        ->assertNotified();

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

    $this
        ->get(route(
            'filament.exports.download',
            ['export' => $export, 'format' => 'csv'],
            absolute: false
        ))
        ->assertDownload()
        ->tap(function ($response) {
            $content = $response->streamedContent();

            foreach (collect(PostExporter::getColumns())->map(fn ($column) => $column->getLabel()) as $label) {
                expect($content)
                    ->toContain($label);
            };

            foreach (Post::all() as $post) {
                expect($content)
                    ->toContain(__digit($post->title1))
                    ->not
                    ->toContain($post->title1)
                    ->toContain($post->title2)
                    ->toContain(__jdatetime(__f_date(), $post->date1))
                    ->not
                    ->toContain($post->date1)
                    ->toContain(__jdatetime(__f_datetime(), $post->date2));
            }
        });
});
