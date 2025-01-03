<?php

    namespace App\Filament\Resources;

    use App\Enums\TalkLength;
    use App\Enums\TalkStatus;
    use App\Filament\Resources\TalkResource\Pages;
    use App\Models\Talk;
    use Filament\Forms\Form;
    use Filament\Notifications\Notification;
    use Filament\Resources\Resource;
    use Filament\Tables;
    use Filament\Tables\Table;
    use Illuminate\Database\Eloquent\Collection;
    use Str;

    class TalkResource extends Resource
    {
        protected static ?string $model = Talk::class;

        protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

        public static function form(Form $form): Form
        {
            return $form
                ->schema(Talk::getForm());
        }

        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    Tables\Columns\TextColumn::make('title')
                        ->sortable()
                        ->searchable()
                        ->description(function (Talk $record) {
                            return Str::limit($record->abstract, 40);
                        }),
                    Tables\Columns\ImageColumn::make('speaker.avatar')
                        ->label('Speaker Avatar')
                        ->circular()
                        ->defaultImageUrl(function ($record) {
                            return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($record->speaker->name);
                        }),
                    Tables\Columns\TextColumn::make('speaker.name')
                        ->sortable()
                        ->searchable(),
                    Tables\Columns\ToggleColumn::make('new_talk'),
                    Tables\Columns\TextColumn::make('status')
                        ->badge()
                        ->color(function ($state) {
                            return $state->getColor();
                        })
                        ->sortable(),
                    Tables\Columns\IconColumn::make('length')
                        ->icon(function ($state) {
                            return match ($state) {
                                TalkLength::NORMAL => 'heroicon-o-megaphone',
                                TalkLength::LIGHTNING => 'heroicon-o-bolt',
                                TalkLength::KEYNOTE => 'heroicon-o-key',
                            };
                        }),
                ])
                ->filters([
                    //
                ])
                ->actions([
                    Tables\Actions\EditAction::make()
                        ->slideOver(),
                    // Tables\Actions\DeleteAction::make(),
                    //  Tables\Actions\ViewAction::make(),
                    Tables\Actions\ActionGroup::make([
                        Tables\Actions\Action::make('approve')
                            ->label('Approve')
                            ->color('success')
                            ->icon('heroicon-o-check-circle')
                            ->requiresConfirmation()
                            ->visible(function (Talk $record) {
                                return $record->status !== TalkStatus::APPROVED;
                            })
                            ->action(function (Talk $record) {
                                $record->approve();
                            })
                            ->after(function () {
                                Notification::make()
                                    ->success()
                                    ->title('Approved')
                                    ->icon('heroicon-o-check-circle')
                                    ->body('The talk has been approved.')
                                    ->send();
                            }),
                        Tables\Actions\Action::make('reject')
                            ->label('Reject')
                            ->color('danger')
                            ->icon('heroicon-o-x-circle')
                            ->requiresConfirmation()
                            ->visible(function (Talk $record) {
                                return $record->status !== TalkStatus::REJECTED;
                            })
                            ->action(function (Talk $record) {
                                $record->reject();
                            })
                            ->after(function () {
                                Notification::make()
                                    ->danger()
                                    ->icon('heroicon-o-x-circle')
                                    ->title('Rejected')
                                    ->body('The talk has been rejected.')
                                    ->send();
                            }),
                        Tables\Actions\Action::make('submit')
                            ->label('Submit')
                            ->color('warning')
                            ->icon('heroicon-o-pencil')
                            ->requiresConfirmation()
                            ->visible(function (Talk $record) {
                                return $record->status !== TalkStatus::SUBMITTED;
                            })
                            ->action(function (Talk $record) {
                                $record->submit();
                            })
                            ->after(function () {
                                Notification::make()
                                    ->warning()
                                    ->icon('heroicon-o-pencil')
                                    ->title('Submitted')
                                    ->body('The talk has been submitted.')
                                    ->send();
                            }),
                    ]),

                ])
                ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\BulkAction::make('approve')
                            ->label('Approve')
                            ->color('success')
                            ->icon('heroicon-o-check-circle')
                            ->action(function (Collection $records) {
                                $records->each->approve();
                            }),
                        Tables\Actions\BulkAction::make('reject')
                            ->label('Reject')
                            ->color('danger')
                            ->icon('heroicon-o-x-circle')
                            ->action(function (Collection $records) {
                                $records->each->reject();
                            }),
                        Tables\Actions\BulkAction::make('submit')
                            ->label('Submit')
                            ->color('warning')
                            ->icon('heroicon-o-pencil')
                            ->action(function (Collection $records) {
                                $records->each->submit();
                            }),
                        Tables\Actions\RestoreBulkAction::make(),
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
                'index' => Pages\ListTalks::route('/'),
                'create' => Pages\CreateTalk::route('/create'),
                'edit' => Pages\EditTalk::route('/{record}/edit'),
            ];
        }
    }
