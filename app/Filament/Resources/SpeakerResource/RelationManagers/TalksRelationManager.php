<?php

    namespace App\Filament\Resources\SpeakerResource\RelationManagers;

    use App\Enums\TalkLength;
    use App\Enums\TalkStatus;
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
            $visible = fn($record) => $record->status !== TalkStatus::APPROVED;
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
                                TalkLength::LIGHTNING => 'heroicon-o-megaphone',
                                TalkLength::NORMAL => 'heroicon-o-document-text',
                                TalkLength::KEYNOTE => 'heroicon-o-finger-print',
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
                        ->visible($visible)
                        ->slideOver(),
                    Tables\Actions\DeleteAction::make()
                        ->visible($visible),
                ])
                ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]),
                ]);
        }
    }
