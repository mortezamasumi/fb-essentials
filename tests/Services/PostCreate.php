<?php

namespace Mortezamasumi\FbEssentials\Tests\Services;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PostCreate extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

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

    public function render(): View
    {
        return view('post-create');
    }
}
