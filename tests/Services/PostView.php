<?php

namespace Mortezamasumi\FbEssentials\Tests\Services;

use Carbon\Carbon;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PostView extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    protected $post;

    public function mount(Post $post): void
    {
        $this->post = $post;
    }

    public function postInfolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->post)
            ->components([
                TextEntry::make('title1')->localeDigit(),
                TextEntry::make('title2'),
                TextEntry::make('date1')->jDate(),
                TextEntry::make('date2')->jDateTime(),
            ]);
    }

    public function render(): View
    {
        return view('post-view');
    }
}
