<?php

    namespace Database\Seeders;

    use App\Models\Venue;
    use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

    class DatabaseSeeder extends Seeder
    {
        private $faker;

        /**
         * Seed the application's database.
         */
        public function run(): void
        {
            // User::factory(10)->create();

//            User::factory()->create([
//                'name' => 'JuanJota',
//                'email' => 'esnola@gmail.com',
//                'password' => Hash::make('12345678'),
//            ]);
            Venue::factory(12)->create();
            /*    Venue::factory()->create( [
                    'name' => 'Venue 1',
                    'city' => $this->faker->city(),
                    'country' => $this->faker->country(),
                    'postal_code' => $this->faker->postcode(),
                    'region' => $this->faker->randomElement(['US', 'EU', 'AU', 'India', 'Online']),
                ]);
                Venue::factory()->create( [
                    'name' => 'Venue 2',
                    'city' => $this->faker->city(),
                    'country' => $this->faker->country(),
                    'postal_code' => $this->faker->postcode(),
                    'region' => $this->faker->randomElement(['US', 'EU', 'AU', 'India', 'Online']),
                ]);
                Venue::factory()->create( [
                    'name' => 'Venue 3',
                    'city' => $this->faker->city(),
                    'country' => $this->faker->country(),
                    'postal_code' => $this->faker->postcode(),
                    'region' => $this->faker->randomElement(['US', 'EU', 'AU', 'India', 'Online']),
                ]);
                Venue::factory()->create( [
                    'name' => 'Venue 2',
                    'city' => $this->faker->city(),
                    'country' => $this->faker->country(),
                    'postal_code' => $this->faker->postcode(),
                    'region' => $this->faker->randomElement(['US', 'EU', 'AU', 'India', 'Online']),
                ]);*/
        }
    }
