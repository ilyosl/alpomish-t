<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\DeviceListModel;
use App\Models\Events;
use App\Models\EventTime;
use App\Models\KatokQrcodeModel;
use App\Models\NewsModel;
use App\Models\PostDeviceLogModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         \App\Models\User::factory(5)->create();
//           Events::factory()->create();
//         \App\Models\User::factory()->create(['username' => '998903301345']);
//         DeviceListModel::factory()->create([
//             'ip_address'=>'192.168.0.33',
//             'type'=> 1
//         ]);
//        KatokQrcodeModel::factory(10)->create();
//        NewsModel::factory(10)->create();
//        Events::factory()->create();
        EventTime::factory(2)->create();
        /*PostDeviceLogModel::factory()->create([
            'device_ip'=>"192.168.0.31",
            'comingDate' => '12.12.2022',
            'log' => "asldkfjalskdf"
        ]);*/
        /*$this->call([
            EventsSeeder::class
        ]);*/
    }
}
