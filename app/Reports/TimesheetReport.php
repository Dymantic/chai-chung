<?php


namespace App\Reports;


use App\Time\Session;

class TimesheetReport implements SimpleReport
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

    public function slug()
    {
        return "timesheet_{$this->start->format('Y_m_d')}_to_{$this->end->format('Y_m_d')}";
    }

    public function rows()
    {
        return Session::matching([
            'from' => $this->start->startOfDay(),
            'to' => $this->end->endOfDay(),
            'user_id' => $this->user,
            'client_id' => $this->client
        ])->map(function($session) {
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

    public function headings()
    {
        return [
            '日期',
            '天',
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
