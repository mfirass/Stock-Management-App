<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Store;
use App\Charge;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = [
            [
               'name'=>'Admin',
               'email'=>'admin@app.com',
                'is_admin'=>'1',
               'password'=> bcrypt('12345678'),
            ],
            [
               'name'=>'User',
               'email'=>'user@app.com',
                'is_admin'=>'0',
               'password'=> bcrypt('12345678'),
            ],
            [
                'name'=>'Mohammed Firass',
                'email'=>'firass.mohammed02@gmail.com',
                 'is_admin'=>'0',
                'password'=> bcrypt('12345678'),
             ],
        ];
  
        foreach ($user as $key => $value) {
            $u = User::create($value);
            $store = new Store();
            $store -> user_id = $u -> id ;
            $store -> save() ;
            $charge = new Charge();
            $charge -> store_id = $store -> id;
            $charge ->save();
        }
    }
}
