<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            MemberSeeder::class,
            AuthorSeeder::class,
            PublisherSeeder::class,
            BookSeeder::class,
            LoanSeeder::class,
        ]);
    }
}
