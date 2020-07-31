<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;



class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'first_name' =>"Θανος",
            'last_name' => "Ταλαριδης",
            'avatar' => "sjkfbhdjka0dbd541fbe1ca1a045e.jpg.jpg",
            'email' => "thanos@gmail.com",
            'password' =>  Hash::make('thanosthanos'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("admin");
         User::create([
            'first_name' =>"Βαγγελης",
            'last_name' => "Μπιτσιλης",
            'avatar' => "fjmwedkskb0880dbd541fbe1ca1a045e.jpg",
            'email' => "baggelis@gmail.com",
            'password' =>  Hash::make('baggelisbaggelis'),
            'active' => 1,
            'remember_token' => Str::random(10),
        ])->assignRole("admin");

//       Role::create(['name' => 'admin']);
//        $baggelis = Role::create(['name' => 'admin']);



        factory( App\User::class, 15)->create();

        $users = User::findOrFail([3,4,5]);

        foreach ($users as $user){
            $user->assignRole("instructor");
        }


//




    }
}
