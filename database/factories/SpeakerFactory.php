<?php

    namespace Database\Factories;

    use App\Models\Speaker;
    use Illuminate\Database\Eloquent\Factories\Factory;

    class SpeakerFactory extends Factory
    {
        /**
         * The name of the factory's corresponding model.
         *
         * @var string
         */
        protected $model = Speaker::class;

        /**
         * Define the model's default state.
         */
        public function definition(): array
        {
            return [
                'name' => $this->faker->name(),
                'email' => $this->faker->safeEmail(),
                'bio' => $this->faker->text(),
                'qualifications' => $this->faker->words(3, true),
                'twitter_handle' => $this->faker->word(),
            ];
        }
    }
