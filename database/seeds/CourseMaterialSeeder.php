<?php

use App\Course;
use App\Material;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* $courseIds = Course::all('id')->toArray();
		$materialIds = Material::all('id')->toArray();
		$pivot = []; */

		// dd($materialIds);

		// foreach( $courseIds as $courseId ) {
			// $randomMaterialIds = $materialIds;
			// dd($randomMaterialIds);
			// shuffle($randomMaterialIds);

			/* for ( $i = 0; $i < 10; $i++) {
				$pivot[] = [
					'course_id' => rand( 1, 0),
					// 'material' => $materialIds[$i]
					'material' => $materialIds[$i]['id']
				];
			}

		// }

		DB::table('course_material')->insert($pivot); */
		factory(App\CourseMaterial::class, 60)->create();






    }
}
