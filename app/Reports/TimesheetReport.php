<?php


namespace App\Reports;


use App\Time\Session;
use App\Time\TimesheetData;

class TimesheetReport implements SimpleSheetReport
{

    private $start;
    private $end;
    private $user;
    private $client;

    public function __construct($start, $end, $user = null, $client = null)
    {
        $this->start = $start;
        $this->end = $end;
        $this->user = $user;
        $this->client = $client;
    }

    public function rows()
    {
        $sessions =  Session::matching([
            'from' => $this->start->startOfDay(),
            'to' => $this->end->endOfDay(),
            'user_id' => $this->user,
            'client_id' => $this->client
        ]);

        return TimesheetData::from($sessions);

    }

    public function headings()
    {
        return [
            '日期',
            '星期',
            '員工',
            '時間',
            '時間長度',
            '客戶',
            '工作事項',
            '描述',
            '備註',
            '加班 (２小時以內)',
            '加班（２小時以外的時數)',
            '加班 (總時數)',
        ];
    }

    public function date_range_string()
    {
        return "{$this->start->format('m/d Y')} - {$this->end->format('m/d Y')}";
    }

    public function title()
    {
        return "員工時數紀錄";
    }
}
