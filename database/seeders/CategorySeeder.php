<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('primary_categories')->insert([
            [
                'name' => '野菜',
                'sort_order' => '1',
            ],
            [
                'name' => '果物',
                'sort_order' => '2',
            ],
            [
                'name' => '野菜セット',
                'sort_order' => '3',
            ],
            [
                'name' => '果物セット',
                'sort_order' => '4',
            ],
        ]);

        DB::table('secondary_categories')->insert([
            [
                'name' => '白菜',
                'sort_order' => '1',
                'primary_category_id' => 1,
            ],
            [
                'name' => '大根',
                'sort_order' => '2',
                'primary_category_id' => 1,
            ],
            [
                'name' => '里芋',
                'sort_order' => '3',
                'primary_category_id' => 1,
            ],
            [
                'name' => 'れんこん',
                'sort_order' => '4',
                'primary_category_id' => 1,
            ],
            [
                'name' => 'いちご',
                'sort_order' => '5',
                'primary_category_id' => 2,
            ],
            [
                'name' => 'いちじく',
                'sort_order' => '6',
                'primary_category_id' => 2,
            ],
            [
                'name' => '桃',
                'sort_order' => '7',
                'primary_category_id' => 2,
            ],
            [
                'name' => '梨',
                'sort_order' => '8',
                'primary_category_id' => 2,
            ],
        ]);
    }
}
