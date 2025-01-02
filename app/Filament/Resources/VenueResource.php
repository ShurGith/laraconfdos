<?php

    namespace App\Filament\Resources;

    use App\Filament\Resources\VenueResource\Pages;
    use App\Filament\Resources\VenueResource\RelationManagers;
    use App\Models\Venue;
    use Filament\Forms\Form;
    use Filament\Resources\Resource;
    use Filament\Tables;
    use Filament\Tables\Table;
    use Illuminate\Support\Facades\Blade;
    use Illuminate\Support\HtmlString;

    class VenueResource extends Resource
    {
        protected static ?string $model = Venue::class;

        protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

        public static function form(Form $form): Form
        {
            return $form
                ->schema(Venue::getForm()); //Creado a partir de un formulario en el modelo de Venue public static function getForm(): array
        }

        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    Tables\Columns\TextColumn::make('media_count')
                        ->label(new HtmlString(Blade::render('<x-heroicon-o-paper-clip class="w-6 h-6" />')))
                        ->counts('media')
                        ->tooltip(fn(Venue $record): string => "number of attachments: {$record->media_count}"),
                    Tables\Columns\TextColumn::make('name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('city')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('country')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('region')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('postal_code')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('created_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('updated_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                ])
                ->filters([
                    //
                ])
                ->actions([
                    Tables\Actions\ViewAction::make(),
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
                'index' => Pages\ListVenues::route('/'),
                'create' => Pages\CreateVenue::route('/create'),
                'edit' => Pages\EditVenue::route('/{record}/edit'),
            ];
        }
    }
