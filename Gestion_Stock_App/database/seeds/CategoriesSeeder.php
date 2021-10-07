<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $category = [
            [ 'libelle' => 'Huil' ] ,
            [ 'libelle' => 'Graine' ] ,
            [ 'libelle' => 'Tomate' ] ,
            [ 'libelle' => 'Sel' ] ,
            [ 'libelle' => 'Sucre' ] ,
        ];

        foreach ($category as $key => $value) {
            Category::create($value);
        }
    }
}
