<?php

    namespace App\Models;

    use App\Enum\Region;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class Venue extends Model
    {
        use HasFactory;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name',
            'city',
            'country',
            'postal_code',
        ];

        protected $casts = [
            'id' => 'integer',
            'region' => Region::class,
        ];

        public function conferences(): HasMany
        {
            return $this->hasMany(Conference::class);
        }
    }
