<?php

    namespace App\Filament\Resources;

    use App\Filament\Resources\ConferenceResource\Pages;
    use App\Models\Conference;
    use Filament\Forms\Form;
    use Filament\Resources\Resource;
    use Filament\Tables;
    use Filament\Tables\Columns\TextColumn;
    use Filament\Tables\Table;

    //use App\Filament\Resources\ConferenceResource\RelationManagers;

    class ConferenceResource extends Resource
    {
        protected static ?string $model = Conference::class;

        protected static ?string $navigationIcon = 'icon-conference';
        //protected static ?string $activeNavigationIcon = 'icon-conference-activa';
        protected static ?int $navigationSort = 2;
        //protected static ?string $navigationParentItem = 'Notifications';

        protected static ?string $navigationGroup = 'Configuraciones';

        public static function getNavigationBadge(): ?string
        {
            return static::getModel()::count();
        }

//        public static function getNavigationBadgeColor(): ?string
//        {
//            return static::getModel()::count() > 10 ? 'warning' : 'primary';
//        }

        public static function form(Form $form): Form
        {
            return $form
                ->schema(Conference::getForm());
        }

        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    TextColumn::make('name')
                        ->searchable(),
                    TextColumn::make('description')
                        ->limit(50)
                        ->html()
                        ->searchable(),
                    Tables\Columns\IconColumn::make('is_active')
                        ->boolean(),
                    TextColumn::make('status')
                        ->color(fn (string $state): string => match ($state){
                                'draft' => 'info',
                                'archived' => 'danger',
                                'published' => 'success',
                        })
                        ->badge()
                        ->searchable(),
                    TextColumn::make('region')
                        ->searchable(),
                    TextColumn::make('start_date')
                        ->dateTime()
                        ->sortable(),
                    TextColumn::make('end_date')
                        ->dateTime()
                        ->sortable(),
                    TextColumn::make('venue.name')
                        ->numeric()
                        ->sortable(),
                    TextColumn::make('created_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('updated_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                ])
                ->filters([
                    //
                ])
                ->actions([
                    Tables\Actions\EditAction::make(),
                ])
                ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]),
                ]);
        }

        public static function getRelations(): array
        {
            return [
                //
            ];
        }

        public static function getPages(): array
        {
            return [
                'index' => Pages\ListConferences::route('/'),
                'create' => Pages\CreateConference::route('/create'),
                'edit' => Pages\EditConference::route('/{record}/edit'),
            ];
        }
    }
