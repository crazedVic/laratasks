<?php

namespace App\Traits;

trait Logging
{
    //logs a notification to a log file
    public function logNotification($message, $user, $time)
    {
        $file = __DIR__ . "/../../storage/logs/messaging/notification.log";
        $exists = file_exists($file);

        //make new log entry
        $entry = (object)[
            "time" => $time,
            "message" => $message,
            "user" => $user
        ];

        //file exists, overwrite
        if($exists) 
        {
            $current = json_decode(file_get_contents($file));
        }
        else
        {   
            //make new log file
            $current = (object) [
                "entries" => []
            ];
            array_push($current->entries, $entry);
        }
        
        file_put_contents($file, json_encode($current));
    }
}