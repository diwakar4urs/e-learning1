<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use \App;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	 Model::unguard();
    	  $faker = Faker\Factory::create();

        $username =  $faker->userName;
    	$name =  $faker->name;
        $user = new App\User();
        $user->name = $name;
        $user->username = $username;
        $user->email = $faker->email;
        $user->password = bcrypt('password');
        $user->slug     = $user->slug($username);
        $user->role_id = 5;
        $user->phone = $faker->phone;
        $user->address = $faker->address;
        $user->create();
        //  DB::table('users')->insert([
        //     'name' => $name,
        //     'username' => $username,
        //     'email' => $faker->email,
        //     'password' => bcrypt('password'),
        //     'slug' 		=> (new App\User())->slug($name),
        //     'login_enabled' => 1,
        //     'role_id' =>5,
        //     'phone' =>$faker->phone,
        // ]);


    }
}
