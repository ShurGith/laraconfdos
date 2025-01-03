<?php

    namespace App\Filament\Resources;

    use App\Enums\TalkStatus;
    use App\Filament\Resources\SpeakerResource\Pages;
    use App\Filament\Resources\SpeakerResource\RelationManagers;
    use App\Models\Speaker;
    use Filament\Forms\Form;
    use Filament\Infolists\Components\Group;
    use Filament\Infolists\Components\ImageEntry;
    use Filament\Infolists\Components\Section;
    use Filament\Infolists\Components\TextEntry;
    use Filament\Infolists\Infolist;
    use Filament\Resources\Resource;
    use Filament\Tables;
    use Filament\Tables\Table;

    class SpeakerResource extends Resource
    {
        protected static ?string $model = Speaker::class;

        protected static ?string $navigationIcon = 'heroicon-o-megaphone';
        protected static ?string $navigationGroup = 'Configuraciones';
        protected static ?int $navigationSort = 1;

        public static function form(Form $form): Form
        {
            return $form
                ->schema(Speaker::getForm());
        }

        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    Tables\Columns\ImageColumn::make('avatar')
                        ->label('Avatar')
                        ->circular()
                        ->defaultImageUrl(function ($record) {
                            return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($record->name);
                        }),
                    Tables\Columns\TextColumn::make('name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('email')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('twitter_handle')
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
                    Tables\Actions\ViewAction::make()
                        ->slideOver(),
                    Tables\Actions\EditAction::make()
                        ->slideOver(),
                ])
                ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]),
                ]);
        }

        public static function infolist(Infolist $infolist): Infolist
        {
            return $infolist
                ->schema([
                    Section::make('Personal Información')
                        ->columns(3)
                        ->schema([
                            ImageEntry::make('avatar')
                                ->label('Avatar')
                                ->circular(),
                            Group::make()
                                ->columns(2)
                                ->columnSpan(2)
                                ->schema([
                                    TextEntry::make('name')
                                        ->label('Nombre'),
                                    TextEntry::make('email')
                                        ->label('Email'),
                                    TextEntry::make('twitter_handle')
                                        ->label('Twitter')
                                        ->getStateUsing(fn($record) => '#' . $record->twitter_handle)
                                        ->url(fn($record) => 'https://twitter.com/' . $record->twitter_handle),
                                    TextEntry::make('Experiencia')
                                        ->getStateUsing(function ($record) {
                                            return self::getCuenta($record) > 0 ? 'Con Experiencia ' : 'Sin Actuaciones ';
                                        })
                                        ->badge()
                                        ->color(fn($record) => self::getCuenta($record) > 0 ? 'success' : 'danger'
                                        ),
                                    TextEntry::make('Intervenciones')
                                        ->getStateUsing(function ($record) {
                                            $acts = self::getCuenta($record);
                                            return match (true) {
                                                $acts === 0 => 'Sin Actuaciones',
                                                default => $acts . ' Charlas',
                                            };
                                        })
                                        ->color(fn($record) => self::getCuenta($record) > 0 ? 'success' : 'danger')
                                        ->badge(),
                                ]),

                        ]),
                    Section::make('Información Adicional')
                        ->schema([
                            TextEntry::make('bio')
                                ->label('Biografía'),
                            TextEntry::make('qualifications')
                                ->badge()
                                ->label('Calificaciones'),
                        ]),
                ]);

        }

        public static function getCuenta($dato): int
        {
            return $dato->talks()->where('status', TalkStatus::APPROVED)->count();
        }

        public static function getRelations(): array
        {
            return [
                RelationManagers\TalksRelationManager::class,
            ];
        }

        public static function getPages(): array
        {
            return [
                'index' => Pages\ListSpeakers::route('/'),
                'create' => Pages\CreateSpeaker::route('/create'),
                // 'edit' => Pages\EditSpeaker::route('/{record}/edit'),
                'view' => Pages\ViewSpeaker::route('/{record}'),
            ];
        }


    }
