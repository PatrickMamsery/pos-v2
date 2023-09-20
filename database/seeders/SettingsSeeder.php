<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['key' => 'app_name', 'value' => 'Foundas POS'],
            ['key' => 'currency_symbol', 'value' => '$'],
        ];

        foreach ($data as $value) {
            Settings::updateOrCreate([
                'key' => $value['key']
            ], [
                'value' => $value['value']
            ]);
        }
    }
}
