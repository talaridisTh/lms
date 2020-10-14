<?php

namespace Database\Factories;

use App\Utility;
use Illuminate\Database\Eloquent\Factories\Factory;

class UtilityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Utility::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
			'title' => "Home page",
			"first_section" => "first_section",
			"second_section" => "second_section",
			"third_section" => "third_section",
			"fourth_section" => "fourth_section",
			"fifth_section" => "fifth_section",
			"sixth_section" => json_encode([
				"model" => "App\Material",
				"ids" => [rand(1,15), rand(1,15), rand(1,15)],
				"status" => 1
			]),
			"seventh_section" => json_encode([
				"model" => "App\Course",
				"ids" => [rand(1,15), rand(1,15), rand(1,15)],
				"status" => 1
			]),
			"eighth_section" => json_encode([
				"model" => "App\Bundle",
				"ids" => [rand(1,15), rand(1,15), rand(1,15)],
				"status" => 1
			]),
			"fields" => json_encode([
				"first_section" => [ "status" => 1, "content" => 0 ],	//! 0 default 1 custom
				"second_section" => [ "status" => 1, "content" => 0 ],
				"third_section" => [ "status" => 1, "content" => 0 ],
				"fourth_section" => [ "status" => 1, "content" => 0 ],
				"fifth_section" => [ "status" => 1, "content" => 0 ],
			]),
			"created_at" => "2020-10-12 17:44:42",
			"updated_at" => "2020-10-12 17:44:42",
        ];
    }
}