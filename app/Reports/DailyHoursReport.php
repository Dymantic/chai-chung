<?php


namespace App\Reports;


use App\Time\Session;

class DailyHoursReport implements SimpleSheetReport
{

    private $from;
    private $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function rows()
    {
        $sessions = Session::matching([
            'from'      => $this->from->startOfDay(),
            'to'        => $this->to->endOfDay(),
            'user_id'   => null,
            'client_id' => null
        ]);

        return DailyHoursData::from($sessions);
    }

    public function title()
    {
        return '每日總時數';
    }

    public function headings()
    {
        return [
            '日期', '星期', '員工', '時間長度', '加班 (２小時以內)', '加班（２小時以外的時數)', '加班 (總時數)',
        ];
    }

    public function date_range_string()
    {
        $from = $this->from->format('m/d Y');
        $to = $this->to->format('m/d Y');

        return "{$from} - {$to}";
    }
}
