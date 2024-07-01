<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Update_Bus_Lat_Long implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mqtt = MQTT::connection();
        $result = [];
        $mqtt->subscribe('bus/location', function (string $topic, string $message) use ($mqtt, &$result) {
            $result['topic'] = $topic;
            $result['message'] = $message;
            $mqtt->interrupt();
        }, 0);
        $mqtt->loop(true, true);

        if (isset($result['message'])) {
        $location = trim($result['message']); 
        $lat= explode(',', $location)[0];
        $long= explode(',', $location)[1];
        DB::table('bus_coordinates')->where('id', 1)->update(['latitude' => $lat, 'longitude' => $long]);
        echo "Bus Coordinates Updated Successfully";
        } else {
            echo "No message received from MQTT subscription.";
        }
    }
}
