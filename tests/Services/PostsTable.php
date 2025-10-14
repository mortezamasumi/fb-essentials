<?php

namespace Mortezamasumi\FbEssentials\Tests\Services;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Mortezamasumi\FbEssentials\Tests\Services\Post;

class PostsTable extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Post::query())
            ->columns([
                TextColumn::make('title1')->localeDigit(),
                TextColumn::make('title2'),
                TextColumn::make('date1')->jDate(),
                TextColumn::make('date2')->jDateTime(),
            ]);
    }

    public function render(): View
    {
        return view('posts-table');
    }
}
