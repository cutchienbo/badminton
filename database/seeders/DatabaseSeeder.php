<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $yard_data = [
        //     [
        //         'number' => 1,
        //         'active' => 1,
        //         'cost' => 50
        //     ],
        //     [
        //         'number' => 2,
        //         'active' => 1,
        //         'cost' => 50
        //     ],
        //     [
        //         'number' => 3,
        //         'active' => 1,
        //         'cost' => 50
        //     ],
        // ];

        // DB::table('yard')->insert($yard_data);

        // $type_data = [
        //     ['name' => 'drink'],
        //     ['name' => 'shuttlecock']
        // ];

        // DB::table('type')->insert($type_data);

        // $product_data = [
        //     [
        //         'id_type' => 1,
        //         'image_url' => 'anh1.png',
        //         'cost' => 12,
        //         'name' => 'Aquafina',
        //         'quantity' => 12
        //     ],
        //     [
        //         'id_type' => 1,
        //         'image_url' => 'anh2.png',
        //         'cost' => 12,
        //         'name' => 'Revive',
        //         'quantity' => 12
        //     ],
        //     [
        //         'id_type' => 2,
        //         'image_url' => 'anh3.png',
        //         'cost' => 22,
        //         'name' => 'Smash',
        //         'quantity' => 24
        //     ],
        // ];

        // DB::table('product')->insert($product_data);

        $orders_data = [
            [
                'yard_id' => 1,
                'time_start' => Carbon::now(),
                'time_end' => null,
                'cost' => 0
            ],
        ];

        DB::table('orders')->insert($orders_data);

    }
}
