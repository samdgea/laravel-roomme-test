<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Building\Header;
use App\Models\Building\Detail;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cleanup Role & Permission
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Header::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        
        $header = Header::create([
            'building_title' => 'Kos Mamah Lela', 
            'building_address' => 'Jalan Pembina III No.16 RT.05 RW.06 Matraman Jakarta Timur', 
            'building_desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'building_lat_coordinate' => '-6.2061278',
            'building_long_coordinate' => '106.8532384'
        ]);

        $detail_1 = Detail::create([
            'building_header_id' => $header->id,
            'name' => 'Single Bed',
            'rent_duration' => Detail::RENT_MONTHLY,
            'rent_price' => 800000
        ]);

        $detail_2 = Detail::create([
            'building_header_id' => $header->id,
            'name' => 'Double Bed',
            'rent_duration' => Detail::RENT_MONTHLY,
            'rent_price' => 1000000
        ]);
    }
}
