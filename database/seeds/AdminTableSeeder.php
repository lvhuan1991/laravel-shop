<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin::firstOrNew(['username'=>'admin'])->
        fill(['password'=>bcrypt('admin')])->save();
    }
}
