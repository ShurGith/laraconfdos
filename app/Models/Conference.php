<?php

    namespace App\Models;

    use App\Enum\Region;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;

    class Conference extends Model
    {
        use HasFactory;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name',
            'description',
            'is_active',
            'status',
            'region',
            'start_date',
            'end_date',
            'venue_id',
        ];

        protected $casts = [
            'id' => 'integer',
            'is_active' => 'boolean',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'venue_id' => 'integer',
            'region' => Region::class,
        ];

        public function venue(): BelongsTo
        {
            return $this->belongsTo(Venue::class);
        }

        public function speakers(): BelongsToMany
        {
            return $this->belongsToMany(Speaker::class);
        }

        public function talks(): BelongsToMany
        {
            return $this->belongsToMany(Talk::class);
        }
    }
