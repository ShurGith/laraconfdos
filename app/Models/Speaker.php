<?php

    namespace App\Models;

    use Filament\Forms\Components\CheckboxList;
    use Filament\Forms\Components\FileUpload;
    use Filament\Forms\Components\Textarea;
    use Filament\Forms\Components\TextInput;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Database\Eloquent\Relations\HasMany;

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
                FileUpload::make('avatar')
                    ->label("Esta es tu imagen de perfil")
                    ->avatar()
                    ->directory('images/avatars/speakers')
                    ->preserveFilenames()
                    ->imageEditor()
                    ->circleCropper()
                    ->maxSize(1024 * 1024 * 10),
                TextInput::make('email')
                    ->email()
                    ->required(),
                Textarea::make('bio')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('twitter_handle')
                    ->required(),
                CheckboxList::make('qualifications')
                    ->columnSpanFull()
                    ->searchable()
                    ->bulkToggleable()
                    ->options([
                            'business-leader' => 'Business Leader',
                            'charisma' => 'Charismatic Speaker',
                            'first-time' => 'First Time Speaker',
                            'hometown-hero' => 'Hometown Hero',
                            'humanitarian' => 'Works in Humanitarian Field',
                            'laracasts-contributor' => 'Laracasts Contributor',
                            'twitter-influencer' => 'Large Twitter Following',
                            'youtube-influencer' => 'Large YouTube Following',
                            'open-source' => 'Open Source Creator / Maintainer',
                            'unique-perspective' => 'Unique Perspective'
                        ]
                    )
                    ->descriptions([
                        'business-leader' => 'Here is a nice long description',
                        'charisma' => 'This is even more information about why you should pick this one',
                    ])
                    ->columns(3),
            ];
        }

        public function conferences(): BelongsToMany
        {
            return $this->belongsToMany(Conference::class);
        }


        public function talks(): HasMany
        {
            return $this->hasMany(Talk::class);
        }

    }
