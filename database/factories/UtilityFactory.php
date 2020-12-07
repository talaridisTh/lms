<?php

namespace Database\Factories;

use App\Models\Utility;
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
			"primary_editor" => "",
			"secondary_editor" => "",
			// "banners" => json_encode([
			// 	"primary" => [
			// 		"models" => [
			// 			["App\Material" => rand(1,10)],
			// 			["App\Course" => rand(1,10)],
			// 			["App\Material" => rand(1,10)],
			// 			["App\Bundle" => rand(1,10)],
			// 			["App\Material" => rand(1,10)]
			// 		],
			// 		"status" => 1
			// 	],
			// 	"secondary" => [
			// 		"models" => [
			// 			["App\Material" => rand(1,10)],
			// 			["App\Course" => rand(1,10)],
			// 			["App\Material" => rand(1,10)],
			// 			["App\Bundle" => rand(1,10)],
			// 			["App\Material" => rand(1,10)]
			// 		],
			// 		"status" => 1
			// 	],
			// ]),
			"banners" => json_encode([
				"primary" => [
					"models" => [],
					"status" => 0
				],
				"secondary" => [
					"models" => [],
					"status" => 0
				],
			]),
			"fields" => json_encode([
				"primary_editor" => [ "status" => 1, "content" => 0 ],	//! 0 default 1 custom
				"secondary_editor" => [ "status" => 1, "content" => 0 ],
			]),
			"created_at" => "2020-10-12 17:44:42",
			"updated_at" => "2020-10-12 17:44:42",
        ];
    }
}
