<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class GuestSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    $faker = Faker::create('id_ID');
    for ($i=0; $i < 50; $i++) {
      $anggota = [
        $faker->unique()->name,
        $faker->unique()->name,
        $faker->unique()->name,
      ];
      DB::table('guest')->insert([
        'uuid'=>$faker->unique()->uuid,
        'nama'=>$faker->unique()->name,
        'alamat'=>$faker->address,
        'telp'=>$faker->phoneNumber,
        'pekerjaan'=>$faker->company,
        'instansi_id'=>mt_rand(1,2),
        'tujuan'=>$faker->sentence(6,true),
        'anggota'=>json_encode($anggota),
        'cin'=>$faker->dateTimeBetween('-5 months','now','Asia/Makassar'),
        'cout'=>$faker->dateTimeBetween('-5 months','+5 hours','Asia/Makassar'),
        'rating'=>$faker->numberBetween(1,5),
        'kesan'=>$faker->text
      ]);
    }
  }
}
