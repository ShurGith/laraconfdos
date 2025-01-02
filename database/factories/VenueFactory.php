<?php

    namespace Database\Factories;

    use App\Models\Venue;
    use Illuminate\Database\Eloquent\Factories\Factory;

    class VenueFactory extends Factory
    {
        /**
         * The name of the factory's corresponding model.
         *
         * @var string
         */
        protected $model = Venue::class;

        /**
         * Define the model's default state.
         */
        public function definition(): array
        {
            $region = self::region();
            // $region = $this->faker->randomElement(['US', 'EU', 'AU', 'India', 'Online']);
            return [
                'name' => $this->faker->name() . '- ' . $region,
                'city' => $this->faker->city(),
                'country' => $this->faker->country(),
                'postal_code' => $this->faker->postcode(),
                'region' => $region, //$this->faker->randomElement(['US', 'EU', 'AU', 'India', 'Online'])
            ];
        }

        public static function region(): string
        {
            $sitios = ['US', 'EU', 'AU', 'India', 'Online'];
            $value = array_rand($sitios);
            //dd($sitios[$value]);
            return $sitios[$value];

        }
    }
