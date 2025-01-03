<?php

    namespace Database\Factories;

    use App\Enums\TalkLength;
    use App\Enums\TalkStatus;
    use App\Models\Talk;
    use Illuminate\Database\Eloquent\Factories\Factory;

    class TalkFactory extends Factory
    {
        protected $model = Talk::class;

        public function definition(): array
        {
            return [
                'title' => $this->faker->sentence(4),
                'abstract' => $this->faker->text(),
                'speaker_id' => rand(1, 6),//Speaker::factory(),
                'status' => $this->faker->randomElement([TalkStatus::APPROVED, TalkStatus::REJECTED, TalkStatus::SUBMITTED]),
                'length' => $this->faker->randomElement([TalkLength::LIGHTNING, TalkLength::NORMAL, TalkLength::KEYNOTE]),
            ];
        }
    }
