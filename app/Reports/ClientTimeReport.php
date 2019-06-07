<?php


namespace App\Reports;


use App\Time\DateRange;
use Illuminate\Support\Facades\DB;

class ClientTimeReport implements SimpleReport
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
            '客戶姓名',
            '總時數(小時)',
            '加班總時數(小時)'
        ];
    }

    public function rows()
    {
        $rows = DB::table('time_sessions')
                  ->join('clients', 'time_sessions.client_id', '=', 'clients.id')
                  ->select(
                      'clients.name',
                      'clients.client_code',
                      DB::raw('SUM(overtime_minutes) / 60 as overtime'),
                      DB::raw('SUM(UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / (60*60) as total'))
                  ->groupBy('client_id')
                  ->whereBetween('start_time', [$this->from, $this->to])
                  ->get();

        return $rows->map(function($row) {
            return [$row->client_code, $row->name, floatval($row->total), floatval($row->overtime)];
        })->values();
    }

    public function title() {
        return '客戶時間紀錄整理報告';
    }

    public function slug()
    {
        return 'client_time_' . $this->from->format('Ymd') . '_' . $this->to->format('Ymd');
    }
}