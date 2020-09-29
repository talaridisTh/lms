<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Topic;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Topic::factory()->times(8)->create();
    }
}
