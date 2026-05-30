<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Order::create([
            'order_id' => '120081152',
            'customer_name' => 'Younes Belhanda',
            'total_amount' => 10000000,
            'status' => 'belum lunas',
            'order_date' => '2026-06-10',
        ]);
        \App\Models\Order::create([
            'order_id' => '120081153',
            'customer_name' => 'Abdul Mulyono',
            'total_amount' => 1000000,
            'status' => 'lunas',
            'order_date' => '2026-06-10',
        ]);
        \App\Models\Order::create([
            'order_id' => '120081154',
            'customer_name' => 'Bowopra',
            'total_amount' => 500000,
            'status' => 'belum lunas',
            'order_date' => '2026-06-10',
        ]);
        \App\Models\Order::create([
            'order_id' => '120081155',
            'customer_name' => 'Anies Danbaswe',
            'total_amount' => 20000000,
            'status' => 'lunas',
            'order_date' => '2026-06-10',
        ]);
        \App\Models\Order::create([
            'order_id' => '120081156',
            'customer_name' => 'Lihab Hubner',
            'total_amount' => 30000000,
            'status' => 'lunas',
            'order_date' => '2026-06-10',
        ]);
        \App\Models\Order::create([
            'order_id' => '120081157',
            'customer_name' => 'Bakrie Yono',
            'total_amount' => 100000,
            'status' => 'lunas',
            'order_date' => '2026-06-10',
        ]);

        // Second set with incremented order_ids to avoid key conflict but maintain list contents
        \App\Models\Order::create([
            'order_id' => '120081158',
            'customer_name' => 'Younes Belhanda',
            'total_amount' => 10000000,
            'status' => 'belum lunas',
            'order_date' => '2026-06-10',
        ]);
        \App\Models\Order::create([
            'order_id' => '120081159',
            'customer_name' => 'Abdul Mulyono',
            'total_amount' => 1000000,
            'status' => 'lunas',
            'order_date' => '2026-06-10',
        ]);
        \App\Models\Order::create([
            'order_id' => '120081160',
            'customer_name' => 'Bowopra',
            'total_amount' => 500000,
            'status' => 'belum lunas',
            'order_date' => '2026-06-10',
        ]);
        \App\Models\Order::create([
            'order_id' => '120081161',
            'customer_name' => 'Anies Danbaswe',
            'total_amount' => 20000000,
            'status' => 'lunas',
            'order_date' => '2026-06-10',
        ]);
        \App\Models\Order::create([
            'order_id' => '120081162',
            'customer_name' => 'Lihab Hubner',
            'total_amount' => 30000000,
            'status' => 'lunas',
            'order_date' => '2026-06-10',
        ]);
        \App\Models\Order::create([
            'order_id' => '120081163',
            'customer_name' => 'Bakrie Yono',
            'total_amount' => 100000,
            'status' => 'lunas',
            'order_date' => '2026-06-10',
        ]);
    }
}
