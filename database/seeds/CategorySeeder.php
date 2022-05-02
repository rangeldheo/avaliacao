<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Ramsey\Uuid\Uuid;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $user = $user = User::get();
        $max  = $user->count() - 1;

        DB::table('categories')->insert([
            [
                'id'      => Uuid::uuid4(),
                'title'   => 'Manicure',
                'user_id' => $user[rand(0, $max)]->id,
                'status'  => rand(0, 1),
                'description' => $faker->word
            ],
            [
                'id'      => Uuid::uuid4(),
                'title'   => 'Cabelereiro',
                'user_id' => $user[rand(0, $max)]->id,
                'status'  => rand(0, 1),
                'description' => $faker->word
            ],
            [
                'id'      => Uuid::uuid4(),
                'title'   => 'Maquiagem',
                'user_id' => $user[rand(0, $max)]->id,
                'status'  => rand(0, 1),
                'description' => $faker->word
            ],
            [
                'id'      => Uuid::uuid4(),
                'title'   => 'Tratamento de pele',
                'user_id' => $user[rand(0, $max)]->id,
                'status'  => rand(0, 1),
                'description' => $faker->word
            ],
            [
                'id'      => Uuid::uuid4(),
                'title'   => 'Emagrecimento',
                'user_id' => $user[rand(0, $max)]->id,
                'status'  => rand(0, 1),
                'description' => $faker->word
            ],
        ]);

    }
}
