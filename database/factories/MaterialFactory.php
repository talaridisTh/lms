<?php

namespace Database\Factories;

use App\Material;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MaterialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Material::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
		static $counter = 3;

		$year = rand(2015, 2020);
		$month = rand(1, 12);
		$day = rand(1, 31);
		$hours = rand(0, 23);
		$mins = rand(0, 59);
		$secs = rand(0, 59);

		$types = ['Announcement', 'Video','Link', "Lesson", "Lesson", "Lesson", "Lesson", "Section", "Section"];

		$date = Carbon::create($year, $month, $day, $hours, $mins, $secs);

        return [
            'title' => "Title of Lesson ".$counter ,
			'subtitle' => "Subtitle of Lesson ".$counter ,
			'cover' => $this->faker->imageUrl(),
			'description' => "Description of Lesson ".$counter ,
			'content' => "Content of Lesson ".$counter++ ,
			'status' => rand( 0, 1 ),
			'slug' => $this->faker->slug,
			'type' => $types[ rand(0,8) ],
			'created_at' => $date->format('Y-m-d H:i:s'),
			'updated_at' => $date->addWeeks(rand(1, 12))->subSeconds(rand(36000, 136000))->format('Y-m-d H:i:s')
        ];
    }
}
