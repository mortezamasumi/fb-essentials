<?php

namespace Mortezamasumi\FbEssentials\Tests\Services;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class PostCreate extends Page
{
    public ?Model $record = null;
    public ?array $data = [];

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title1')->toEN(),
                TextInput::make('title2')->toFA(),
                DatePicker::make('date1')->jDate(),
                DateTimePicker::make('date2')->jDateTime(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        Post::create($this->form->getState());
    }
}
