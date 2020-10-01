<?php

namespace Database\Factories;

use App\Section;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Section::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
		static $counter = 1;

		$year = rand(2018, 2021);
		$month = rand(1, 12);
		$day = rand(1, 31);
		$hours = rand(0, 23);
		$mins = rand(0, 59);
		$secs = rand(0, 59);

		$status = rand( 0, 1 );

		$date = Carbon::create($year, $month, $day, $hours, $mins, $secs);

        return [
			"status" => $status,
            "priority" => $counter++,
			"created_at" => $date->format('Y-m-d H:i:s'),
			"updated_at" => $date->addWeeks( rand(1, 12) )->subSeconds( rand(36000, 136000) )->format('Y-m-d H:i:s'),
			"publish_at" => $status == 1 ? $date->addYears( rand(1, 2) ) : null,
        ];
    }
}
