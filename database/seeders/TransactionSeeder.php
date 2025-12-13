<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{

    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $categories = Category::where('user_id', $user->id)
                ->orWhereNull('user_id')
                ->get();

            if ($categories->isEmpty()) {
                continue;
            }

            for ($i = 0; $i < 10; $i++) {
                $category = $categories->random();

                Transaction::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'amount' => fake()->randomFloat(2, 10, 5000),
                    'type' => fake()->randomElement(['income','expense']),
                    'description' => fake()->sentence(),
                    'date' => fake()->dateTimeBetween('-90 days', 'now'),
                ]);
            }
        }
    }
}
