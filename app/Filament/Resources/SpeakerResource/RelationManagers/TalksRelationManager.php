<?php

    namespace App\Filament\Resources\SpeakerResource\RelationManagers;

    use App\Enums\TalkLength;
    use App\Models\Talk;
    use Filament\Forms\Form;
    use Filament\Resources\RelationManagers\RelationManager;
    use Filament\Tables;
    use Filament\Tables\Table;

    class TalksRelationManager extends RelationManager
    {
        protected static string $relationship = 'talks';

        public function isReadOnly(): bool
        {
            return false;
        }

        public function form(Form $form): Form
        {
            return $form
                ->schema(Talk::getForm($this->getOwnerRecord()->id));
        }

        public function table(Table $table): Table
        {
            return $table
                ->recordTitleAttribute('title')
                ->columns([
                    Tables\Columns\TextColumn::make('title'),
                    Tables\Columns\TextColumn::make('status')
                        ->badge()
                        ->color(function ($state) {
                            return $state->getColor();
                        }),
                    Tables\Columns\IconColumn::make('length')
                        ->icon(function ($state) {
                            return match ($state) {
                                TalkLength::NORMAL => 'heroicon-o-megaphone',
                                TalkLength::SHORT => 'heroicon-o-megaphone',
                                TalkLength::LONG => 'heroicon-o-megaphone',
                            };
                        }),

                ])
                ->filters([
                    //
                ])
                ->headerActions([
                    Tables\Actions\CreateAction::make(),
                ])
                ->actions([
                    Tables\Actions\EditAction::make()
                    ->slideOver(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]),
                ]);
        }
    }
