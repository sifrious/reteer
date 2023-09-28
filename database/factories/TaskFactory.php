<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // get a date sometime in the next two months
        $currentDateTime = Carbon::now();
        $dateTime = $currentDateTime->addDays(rand(2, 60))->toDateString();
        $currentDateTime = $currentDateTime->toDateString();
        $name = $this->faker->firstName();
        $sheetsId = $name . $currentDateTime;
        return [
            'sheets_created_at' => "",
            'sheets_id' => $sheetsId,
            'name' => $this->faker->randomDigitNotNull(),
            'author' => $this->faker->firstName(),
            'start_date' => $dateTime,
            'start_time' => $dateTime,
            'public' => rand(0, 1) == 1,
            'client_address' => $this->faker->streetAddress(),
            'task_description' => $this->faker->text(),
            'destination' => $this->faker->streetAddress(),
            'volunteer_id' => null,
            'status' => "unassigned",
            'contact_information' => $this->faker->text(),
        ];
    }
}
