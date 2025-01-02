<?php

    namespace Database\Seeders;

    use App\Models\Conference;
    use App\Models\Speaker;
    use App\Models\Talk;
    use App\Models\User;
    use App\Models\Venue;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

    class DatabaseSeeder extends Seeder
    {
        private $faker;

        /**
         * Seed the application's database.
         */
        public function run(): void
        {
/*            // User::factory(10)->create();
            User::factory()->create([
                'name' => 'JuanJota',
                'email' => 'esnola@gmail.com',
                'password' => Hash::make('12345678'),
            ]);*/
            //dd($user);
//            dump($user);
//            ray($user);
            User::factory()->create([
                'name' => 'JuanJota',
                'email' => 'esnola@gmail.com',
                'password' => Hash::make('12345678'),
            ]);
            Venue::factory(12)->create();
            Conference::factory(12)->create();
            Speaker::factory(12)->create();
            Talk::factory(12)->create();


        }
    }
