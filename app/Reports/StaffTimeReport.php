<?php


namespace App\Reports;


use App\Time\DateRange;
use App\Time\Session;
use Illuminate\Support\Facades\DB;

class StaffTimeReport implements SimpleReport
{
    private $from;
    private $to;

    public function __construct(DateRange $dateRange)
    {
        $this->from = $dateRange->from();
        $this->to = $dateRange->to();
    }

    public function date_range_string()
    {
        return $this->from->format('Y-m-d (D)') . " - " . $this->to->format('Y-m-d (D)');
    }

    public function headings()
    {
        return [
            '代號',
            '姓名',
            '總時數(小時)',
            '加班總時數(小時)'
        ];

    }

    public function rows()
    {
        $rows = DB::table('time_sessions')
                  ->join('users', 'time_sessions.user_id', '=', 'users.id')
                  ->select(
                      'users.name',
                      'users.user_code',
                      DB::raw('SUM(overtime_minutes) / 60 as overtime'),
                      DB::raw('SUM(UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / (60*60) as total'))
                  ->groupBy('user_id')
                  ->whereBetween('start_time', [$this->from, $this->to])
                  ->get();

        return $rows->map(function ($row) {
            return [$row->user_code, $row->name, floatval($row->total), floatval($row->overtime)];
        })->values();
    }

    public function title()
    {
        return '員工時間紀錄整理報告';
    }

    public function slug()
    {
        return 'staff_time_' . $this->from->format('Ymd') . '_' . $this->to->format('Ymd');
    }
}