<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\BusEventNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class Read_Bus_Accelerometer_Readings implements ShouldQueue
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
        $mqtt->subscribe('bus/alert', function (string $topic, string $message) use ($mqtt, &$result) {
            $result['topic'] = $topic;
            $result['message'] = $message;
            $mqtt->interrupt();
        }, 0);
        $mqtt->loop(true, true);

        if (isset($result['message'])) {
            $status = trim($result['message']);
            if ($status != "Invalid") {
                $users=User::all();
                if ($status == "Acceleration") {
                    Notification::send($users,new BusEventNotification("Sudden acceleration detected on the bus. Please check."));
                } else if($status == "Accident") {
                    Notification::send($users,new BusEventNotification("We regret to inform you that there has been an accident involving your child's school bus."));
                }
                $location = DB::table('bus_coordinates')->where('id', 1)->first();
                DB::table('bus_accelerometer_readings')->insert(['latitude' => $location->latitude , 'longitude' => $location->longitude, 'status' => $status,'created_at' => now()]);  
                $mqtt->publish('bus/alert', "Invalid", 0, true);
                $mqtt->loop(true, true);
            } else {
                echo "Invalid Readings from Accelerometer";
            }
        } else {
            echo "No message received from MQTT subscription.";
        }
    }
}
