<?php

    namespace App\Models;

    // use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Filament\Models\Contracts\FilamentUser;
    use Filament\Models\Contracts\HasAvatar;
    use Filament\Panel;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class User extends Authenticatable implements FilamentUser, HasAvatar
    {
        use HasFactory, Notifiable;

        protected $fillable = [
            'name',
            'email',
            'password',
        ];
        protected $hidden = [
            'password',
            'remember_token',
        ];

        public function getFilamentAvatarUrl(): ?string
        {
            // dd($this->avatar);
            return $this->avatar;
        }

        public function canAccessPanel(Panel $panel): bool
        {
            return true; //str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
        }

        protected function casts(): array
        {
            return [
                'email_verified_at' => 'datetime',
                'password' => 'hashed',
            ];
        }
    }
