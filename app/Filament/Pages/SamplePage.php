<?php

namespace App\Filament\Pages;

use App\Models\Customer;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;
use Filament\Resources\Pages\Concerns\HasWizard;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class SamplePage extends Page implements HasTable
{
    use HasWizard;
    use InteractsWithTable;

    public array $data=[];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.sample-page';

    public function mount()
    {
        $this->form->fill([]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('test')
                ->action(fn($data) => dd('test'))
                ->steps([
                    Wizard\Step::make('sd')
                        ->schema([
                            TextInput::make('name'),
                        ]),
                ])
                ->icon('heroicon-o-minus-circle')
                ->color('warning'),
        ];
    }

    public function form(Form $form): Form
    {
        return parent::form($form)
            ->statePath('data')
            ->schema([
                Wizard::make($this->getSteps())
                    ->startOnStep($this->getStartStep())
                    ->cancelAction($this->getCancelFormAction())
                    ->submitAction($this->getSubmitFormAction())
                    ->skippable($this->hasSkippableSteps()),
            ])
            ->columns(null);
    }

    protected function getSteps(): array
    {
        return [
            Wizard\Step::make('Name')
                ->schema([
                    TextInput::make('name')
                ]),
            Wizard\Step::make('Email')
                ->schema([
                    TextInput::make('email')
                ]),
        ];
    }

    protected function getCancelFormAction(): ?Action
    {
        return null;
    }

    protected function getSubmitFormAction(): Action
    {
        return Action::make('create')
            ->label(__('filament-panels::resources/pages/create-record.form.actions.create.label'))
            ->submit('create')
            ->keyBindings(['mod+s', 'mod+enter']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()->limit(5))
            ->paginated(false)
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
            ]);
    }
}
