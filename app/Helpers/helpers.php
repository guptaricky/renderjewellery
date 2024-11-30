<?php

use Carbon\Carbon;

if (!function_exists('formatTimestamp')) {
    /**
     * Format the timestamp into a human-readable format.
     *
     * @param  mixed  $timestamp
     * @param  string  $timezone
     * @return string
     */
    function formatTimestamp($timestamp, $timezone = 'Asia/Kolkata')
    {
        $carbonTime = Carbon::parse($timestamp);

        // If it's more than 24 hours ago, return a "diffForHumans" format
        if ($carbonTime->diffInHours() > 24) {
            return $carbonTime->diffForHumans();
        }

        // Otherwise, return the time in the specified timezone
        return $carbonTime->setTimezone($timezone)->format('H:i a');
    }
}