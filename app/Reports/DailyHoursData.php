<?php


namespace App\Reports;


class DailyHoursData
{
    public static function from($sessions)
    {
        $staff = self::groupByStaffMember($sessions);

        return $staff->flatMap(function ($sessions) {
            return self::extractDailyData($sessions)->merge([['', '', '', '', '', '', '',]])->all();
        })->values();

    }

    private static function groupByStaffMember($sessions)
    {
        return $sessions->groupBy(function ($session) {
            return $session->user->id;
        });
    }

    private static function groupByDay($sessions)
    {
        return $sessions
            ->groupBy(function ($session) {
                return $session->start_time->format('mdY');
            });
    }

    private static function extractDailyData($sessions)
    {
        return self::groupByDay($sessions)
            ->map(function ($ds) {
                return self::summaryOfDailySessions($ds);
            })->values();
    }

    private static function summaryOfDailySessions($ds)
    {
        $total_minutes = $ds->sum(function ($s) {
            return $s->duration()->minutes();
        });
        $total_hours = $total_minutes / 60;
        $total_overtime = $total_hours >= 8 ? $total_hours - 8 : 0;
        $first_overtime = $total_overtime >= 2 ? 2 : $total_overtime;
        $extra_overtime = $total_overtime - $first_overtime;

        return [
            $ds[0]->start_time->format('m/d Y'),
            $ds[0]->start_time->format('D'),
            $ds[0]->user->name,
            $total_hours,
            $first_overtime,
            $extra_overtime,
            $total_overtime,
        ];
    }
}
