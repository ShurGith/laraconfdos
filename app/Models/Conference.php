<?php

    namespace App\Models;

    use App\Enums\Region;
    use Filament\Forms\Components\Actions;
    use Filament\Forms\Components\Actions\Action;
    use Filament\Forms\Components\CheckboxList;
    use Filament\Forms\Components\DateTimePicker;
    use Filament\Forms\Components\Fieldset;
    use Filament\Forms\Components\RichEditor;
    use Filament\Forms\Components\Section;
    use Filament\Forms\Components\Select;
    use Filament\Forms\Components\TextInput;
    use Filament\Forms\Components\ToggleButtons;
    use Filament\Forms\Get;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;

    class Conference extends Model
    {
        use HasFactory;

        protected $casts = [
            'id' => 'integer',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'region' => Region::class,
            'venue_id' => 'integer',
        ];

        public static function getForm(): array
        {
            return [
                Section::make('Conference Details')
                    ->collapsible()
                    ->description('Provide some basic information about the conference.')
                    ->icon('heroicon-o-information-circle')
                    //->aside()
                    ->columns([
                        'sm' => 1,
                        'md' => 1,
                        'lg' => 4,
                        'xl' => 4,
                    ])
                    ->schema([
                        TextInput::make('name')
                            ->label('Conference Name')
                            ->default('My Conference')
                            ->required()
                            ->maxLength(60)
                            ->columnSpan(3),
                        Fieldset::make('Status')
                            ->columns(3)
                            ->schema([
                                ToggleButtons::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'archived' => 'Archived',
                                    ])
                                    ->icons([
                                        'draft' => 'heroicon-o-wrench-screwdriver',
                                        'archived' => 'heroicon-m-inbox-stack',
                                        'published' => 'heroicon-c-clipboard-document-check',
                                    ])
                                    ->colors([
                                        'draft' => 'info',
                                        'archived' => 'danger',
                                        'published' => 'warning',
                                    ])
                                    ->columnSpan(2)
                                    ->default('draft')
                                    ->inline()
                                    ->gridDirection('row')
                                    ->grouped()
                                    ->required(),
                                ToggleButtons::make('is_active')
                                    ->label('¿Activo este evento?')
                                    ->default(false)
                                    ->options(
                                        [
                                            true => 'Yes',
                                            false => 'No',
                                        ]
                                    )
                                    ->icons([
                                        true => 'heroicon-c-check-circle',
                                        false => 'heroicon-c-no-symbol',
                                    ])
                                    ->colors([
                                        true => 'warning',
                                        false => 'danger',
                                    ])
                                    //  ->boolean()
                                    ->grouped()
                            ]),
                        RichEditor::make('description')
                            ->columnSpanFull()
                            ->required(),
                        DateTimePicker::make('start_date')
                            ->required()
                            ->columnSpan(2),
                        DateTimePicker::make('end_date')
                            ->required()
                            ->columnSpan(2),
                        CheckboxList::make('speakers')
                            ->relationship('speakers', 'name')
                            ->options(
                                Speaker::all()->pluck('name', 'id')
                            )
                            ->searchable()
                            ->bulkToggleable()
                            ->columnSpanFull()
                            ->columns([
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                                'xl' => 4,
                            ])
                            ->required(),

                        Fieldset::make('Location ')
                            //->columns()
                            //  ->description('Select the region and venue for the conference.')
                            ->schema([
                                Select::make('region')
                                    ->live()
                                    ->enum(Region::class)
                                    ->options(Region::class),
                                Select::make('venue_id')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm(Venue::getForm())
                                    ->editOptionForm(Venue::getForm())
                                    ->relationship('venue', 'name', modifyQueryUsing: function (Builder $query, Get $get) {
                                        return $query->where('region', $get('region'));
                                    }),
                            ]),
                    ]),
                Actions::make(actions: [
                    Action::make('star')
                        ->label('Fill with Factory Data')
                        ->icon('heroicon-m-star')
                        ->visible(function (string $operation) {
                            if($operation !== 'create') {
                                return false;
                            }
                            if(! app()->environment('local')) {
                                return false;
                            }
                            return true;
                        })
                        ->action(function ($livewire) {
                            $data = Conference::factory()->make()->toArray();
                            $livewire->form->fill($data);
                        }),
                ]),
            ];
        }

        public function venue(): BelongsTo
        {
            return $this->belongsTo(Venue::class);
        }

        public function speakers(): BelongsToMany
        {
            return $this->belongsToMany(Speaker::class);
        }

        public function talks(): BelongsToMany
        {
            return $this->belongsToMany(Talk::class);
        }
    }
