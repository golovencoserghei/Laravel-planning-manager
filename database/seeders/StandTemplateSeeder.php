<?php

namespace Database\Seeders;

use App\Models\Congregation;
use App\Models\Stand;
use App\Models\StandPublishers;
use App\Models\StandTemplate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StandTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $congregation = [
            'name' => 'Бэлц',
        ];

        $congregation_id = DB::table(app(Congregation::class)->getTable())->insertGetId($congregation);

        $stands = [
            [
                'congregation_id' => $congregation_id,
                'name' => 'Стелуца',
                'location' => 'ул. Стелуца',
            ],
            
            [
                'congregation_id' => $congregation_id,
                'name' => 'Борис Главан',
                'location' => 'ул. Б. Главан',
            ],
        ];

        foreach($stands as $stand) {
            DB::table(app(Stand::class)->getTable())->insert($stand);
        }

        $stand_templates = [
            [
                'type' => 'current',
                'day' => 1,
                'times_range' => json_encode([8,9,10,11,12,13,14,15,16]),
                'stand_id' => Stand::whereName('Стелуца')->first()->id,
                'congregation_id' => $congregation_id,
            ],
            [
                'type' => 'current',
                'day' => 2,
                'times_range' => json_encode([8,9,10,11,12,13,14,15,16]),
                'stand_id' => Stand::whereName('Стелуца')->first()->id,
                'congregation_id' => $congregation_id,
            ],
            
            [
                'type' => 'current',
                'day' => 1,
                'times_range' => json_encode([8,9,10,11,12,13,14,15,16]),
                'stand_id' => Stand::whereName('Борис Главан')->first()->id,
                'congregation_id' => $congregation_id,
            ],
            [
                'type' => 'current',
                'day' => 3,
                'times_range' => json_encode([8,9,10,11,12,13,14,15,16]),
                'stand_id' => Stand::whereName('Борис Главан')->first()->id,
                'congregation_id' => $congregation_id,
            ],

            [
                'type' => 'next',
                'day' => 1,
                'times_range' => json_encode([8,9,10,11,12,13,14,15,16]),
                'stand_id' => Stand::whereName('Стелуца')->first()->id,
                'congregation_id' => $congregation_id,
            ],
            [
                'type' => 'next',
                'day' => 2,
                'times_range' => json_encode([8,9,10,11,12,13,14,15,16]),
                'stand_id' => Stand::whereName('Стелуца')->first()->id,
                'congregation_id' => $congregation_id,
            ],
        ];

        foreach($stand_templates as $stand_template) {
            $stand_template_id = DB::table(app(StandTemplate::class)->getTable())->insertGetId($stand_template);
        }

        StandPublishers::create([
            'stand_template_id' => StandTemplate::first()->id,
            'time' => 8,
            'user_1' => User::first()->id,
            'user_2' => User::skip(1)->take(1)->first()->id,
            'date' => now()->timestamp
        ]);
    }
}
