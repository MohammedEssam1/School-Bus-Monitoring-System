<?php

namespace App\Jobs;

use App\Models\Tag;
use App\Models\Attendance;
use Illuminate\Bus\Queueable;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Check_RFID implements ShouldQueue
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
        $mqtt->subscribe('emqx/esp8266', function (string $topic, string $message) use ($mqtt, &$result) {
            $result['topic'] = $topic;
            $result['message'] = $message;
            $mqtt->interrupt();
        }, 0);
        $mqtt->loop(true, true);

        if (isset($result['message'])) {
            $tag = Tag::where('tag', trim($result['message']))->first();
            if ($tag) {
                $current_date = date('Y-m-d');
                $att = Attendance::where([
                    'student_id' => $tag->student_id,
                    'attendence_date' => $current_date
                ])->first();
                if (!$att) {
                    Attendance::create([
                        'student_id' => $tag->student_id,
                        'attendence_date' => $current_date,
                        'attendence_status' => 'Present'
                    ]);
                    echo "Successfully Registered";
                } else {
                    echo "Already Registered";
                }
            } else {
                echo "Invalid Tag";
            }
        } else {
            echo "No message received from MQTT subscription.";
        }

    }
}
