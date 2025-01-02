<?php

    namespace App\Models;

    use Filament\Forms\Components\CheckboxList;
    use Filament\Forms\Components\Textarea;
    use Filament\Forms\Components\TextInput;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;

    class Speaker extends Model
    {
        use HasFactory;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name',
            'email',
            'bio',
            'twitter_handle',
        ];

        protected $casts = [
            'id' => 'integer',
            'qualifications' => 'array',
        ];

        public static function getForm(): array
        {
            return [
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                Textarea::make('bio')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('twitter_handle')
                    ->required(),
                CheckboxList::make('qualifications')
                    ->options([
                        'Speaker' => 'Speaker',
                    ])
                    //->descriptions('Options')
                    ->required()
                    ->searchable()
                    ->bulkToggleable()
                    ->columns(3)
                    ->columnSpanFull(),
            ];
        }

        public function conferences(): BelongsToMany
        {
            return $this->belongsToMany(Conference::class);
        }

    }
