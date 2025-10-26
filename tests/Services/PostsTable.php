<?php

namespace Mortezamasumi\FbEssentials\Tests\Services;

use Filament\Pages\Page;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Mortezamasumi\FbEssentials\Tests\Services\Post;

class PostsTable extends Page implements HasTable
{
    use InteractsWithTable;

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                EmbeddedTable::make(),
            ]);
    }

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
}
