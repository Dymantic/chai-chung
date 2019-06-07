<?php


namespace App\Reports;


use App\Time\DateRange;
use Illuminate\Support\Facades\DB;

class EngagementTimeReport implements SimpleReport
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

    public function headings() {
        return [
            '代號',
            '工作說明',
            '總時數(小時)',
            '加班總時數(小時)'
        ];
    }

    public function rows()
    {
        $rows = DB::table('time_sessions')
                  ->join('engagement_codes', 'time_sessions.engagement_code_id', '=', 'engagement_codes.id')
                  ->select(
                      'engagement_codes.description',
                      'engagement_codes.code',
                      DB::raw('SUM(overtime_minutes) / 60 as overtime'),
                      DB::raw('SUM(UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / (60*60) as total'))
                  ->groupBy('engagement_code_id')
                  ->whereBetween('start_time', [$this->from, $this->to])
                  ->get();

        return $rows->map(function($row) {
            return [$row->code, $row->description, floatval($row->total), floatval($row->overtime)];
        })->values();
    }

    public function title() {
        return '工作事項時間紀錄整理報告';
    }

    public function slug()
    {
        return 'engagement_time_' . $this->from->format('Ymd') . '_' . $this->to->format('Ymd');
    }
}