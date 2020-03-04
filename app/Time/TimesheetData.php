<?php


namespace App\Time;


class TimesheetData
{
    public static function from($sessions)
    {
        return $sessions->map(function($session) {
            $data = $session->toArray();
            $overtime = $data['overtime'] ? $data['overtime'] / 60 : 0;
            return [
                $data['date'],
                $data['day_of_week'],
                $data['user'],
                "{$data['start_time']} - {$data['end_time']}",
                $data['duration'],
                $data['client_name'],
                $data['engagement_code_description'],
                $data['description'],
                $data['notes'],
                $overtime >= 2 ? 2 : $overtime,
                $overtime >= 2 ? $overtime - 2 : 0,
                $overtime,
            ];
        });
    }
}
