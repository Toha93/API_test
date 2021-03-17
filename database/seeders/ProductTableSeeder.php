<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prod = array(
            array('name'=>'Молоко "простоквашино"',
                'description'=>'Молоко "простоквашино" 3.2%',
                'slug'=>'moloko_prostokvashino32',
                'category_id'=>'3',
                'price'=>'50'),
            array('name'=>'Молоко "Домик в деревне"',
                'description'=>'Молоко "Домик в деревне" 2.5%',
                'slug'=>'moloko_domik_v_derevne25',
                'category_id'=>'3',
                'price'=>'50'),
            array('name'=>'Сосиски куриные"',
                'description'=>'Сосиски куринные 500гр',
                'slug'=>'sosiski_kurinnii_500gr',
                'category_id'=>'8',
                'price'=>'200'),
            array('name'=>'Сосиски свиные"',
                'description'=>'Сосиски свиные 500гр',
                'slug'=>'sosiski_svinii_500gr',
                'category_id'=>'8',
                'price'=>'250'),
            array('name'=>'Сосиски говяжии"',
                'description'=>'Сосиски говяжии 500гр',
                'slug'=>'sosiski_goviagii_500gr',
                'category_id'=>'8',
                'price'=>'300'),
            array('name'=>'Йогурт DANONE',
                'description'=>'Йогурт DANONE 200мл',
                'slug'=>'yogurt_DANONE_200ml',
                'category_id'=>'2',
                'price'=>'80'),
            array('name'=>'Йогурт DANONE большой',
                'description'=>'Йогурт DANONE 500мл',
                'slug'=>'yogurt_DANONE_500ml',
                'category_id'=>'2',
                'price'=>'150'),
            array('name'=>'Йогурт DANONE средний',
                'description'=>'Йогурт DANONE 300мл',
                'slug'=>'yogurt_DANONE_300ml',
                'category_id'=>'2',
                'price'=>'120'),
            array('name'=>'котлеты "мясные"',
                'description'=>'котлеты "мясные"',
                'slug'=>'kotleti',
                'category_id'=>'6',
                'price'=>'300')

        );
        foreach($prod as $cat){
            $category = new Product;
            $category->name = $cat['name'];
            $category->category_id = $cat['category_id'];
            $category->description = $cat['description'];
            $category->slug = $cat['slug'];
            $category->price = $cat['price'];

            $category->save();
        }
    }
}
