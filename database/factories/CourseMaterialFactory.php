<?php

namespace Database\Factories;

use App\CourseMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CourseMaterialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseMaterial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
		$year = rand(2018, 2021);
		$month = rand(1, 12);
		$day = rand(1, 31);
		$hours = rand(0, 23);
		$mins = rand(0, 59);
		$secs = rand(0, 59);

		$date = Carbon::create($year, $month, $day, $hours, $mins, $secs);

        return [
            'course_id' => $this->faker->numberBetween( 1, 15),
			'material_id' => $this->faker->numberBetween( 1, 10),
			'status' => $this->faker->numberBetween( 0, 1 ),
			'priority' => $this->faker->numberBetween( 1, 10000),
			'publish_at' => $date
        ];
    }
}
