<?php

	namespace App\Filament\Resources;

	use App\Enum\Region;
	use App\Filament\Resources\ConferenceResource\Pages;
	use App\Filament\Resources\ConferenceResource\RelationManagers;
	use App\Models\Conference;
	use Filament\Forms;
	use Filament\Forms\Form;
	use Filament\Resources\Resource;
	use Filament\Tables;
	use Filament\Tables\Table;

	class ConferenceResource extends Resource
	{
		protected static ?string $model = Conference::class;

		protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

		public static function form(Form $form): Form
		{
			return $form
				->schema([
					Forms\Components\TextInput::make('name')
						->label('Conference Name')
						->helperText('Aqui va el helper texto')
						->prefix('https://')
						->prefixIcon('heroicon-o-link')
						->suffix('.com')
						->suffixIcon('heroicon-o-check-circle')
						->hint('El campo es requerido')
						->HintColor('danger')
						->hintIcon('heroicon-o-exclamation-triangle')
						->dehydrateStateUsing(fn($state) => strtolower($state))
						->hintIconTooltip('El campo es requerido')
						->required(),
					Forms\Components\RichEditor::make('description')
						->required(),
					Forms\Components\Select::make('region')
						->options(Region::class)
						->required(),
					Forms\Components\DateTimePicker::make('start_date')
						->default(now())
						->required(),
					Forms\Components\DateTimePicker::make('end_date')
						->required(),
					Forms\Components\Select::make('venue_id')
						->relationship('venue', 'name'),
					Forms\Components\Toggle::make('is_active')
						->required(),
					Forms\Components\Select::make('status')
						->required(),
				]);
		}

		public static function table(Table $table): Table
		{
			return $table
				->columns([
					Tables\Columns\TextColumn::make('name')
						->searchable(),
					Tables\Columns\TextColumn::make('description')
						->searchable(),
					Tables\Columns\IconColumn::make('is_active')
						->boolean(),
					Tables\Columns\TextColumn::make('status')
						->searchable(),
					Tables\Columns\TextColumn::make('region')
						->searchable(),
					Tables\Columns\TextColumn::make('start_date')
						->dateTime()
						->sortable(),
					Tables\Columns\TextColumn::make('end_date')
						->dateTime()
						->sortable(),
					Tables\Columns\TextColumn::make('venue.name')
						->numeric()
						->sortable(),
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
