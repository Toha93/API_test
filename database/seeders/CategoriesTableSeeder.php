<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = array(
            array('name'=>'Молочные продукты'),
            array('name'=>'Кисломолочные продукты',
                    'category_id'=>'1'),
            array('name'=>'Молоко',
                'category_id'=>'1'),
            array('name'=>'Йогурты',
                'category_id'=>'2'),
            array('name'=>'Обезжиренное',
                'category_id'=>'3'),
            array('name'=>'Мясные продукты'),
            array('name'=>'Полуфабрикаты',
                'category_id'=>'6'),
            array('name'=>'Сосиски',
                'category_id'=>'7'),
        );
        foreach($cats as $cat){
            $category = new Category;
            $category->name = $cat['name'];
            if(isset($cat['category_id'])) {
                $category->category_id = $cat['category_id'];
            }
            $category->save();
        }
        //
    }
}
