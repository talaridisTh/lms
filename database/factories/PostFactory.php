<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;
      $slug =   Str::slug($title, '-');
        return [
            //
            'user_id' =>User::all('id')->random(),
            'course_id' =>Course::all('id')->random(),
            'title' => $title,
            'slug' => $slug,
            'body' => $this->faker->paragraph,
            'created_at' => $this->faker->dateTimeBetween('-1 years')
        ];
    }
}
