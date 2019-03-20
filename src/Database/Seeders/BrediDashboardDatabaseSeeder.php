<?php

namespace Bredi\BrediDashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class BrediDashboardDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        User::updateOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'Bredi Tecnologia Digital',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
        ]);
        // $this->call("OthersTableSeeder");
    }
}
