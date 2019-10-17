<?php

namespace App\Http\Requests;

use App\Rules\MaximumHours;
use App\Rules\StartEndTime;
use App\Rules\WorkPeriod;
use App\Rules\WorkPeriodUpdate;
use App\Time\Holiday;
use App\Time\MakeUpDay;
use App\Time\TimeOfDay;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class UpdateSessionForm extends FormRequest
{

    public function authorize()
    {
        return $this->user()->id === $this->route('session')->user_id;
    }


    public function rules()
    {
        return [
            'session_date' => ['required', 'date'],
            'start_time' => [
                new StartEndTime(),
                new WorkPeriodUpdate(
                    $this->user(),
                    $this->end_time,
                    $this->session_date,
                    $this->route('session')->id
                )
            ],
            'end_time' => [
                new StartEndTime(request('start_time')),
                new MaximumHours(4, request('start_time'))
            ],
            'service_period'     => ['required'],
            'client_id'          => ['exists:clients,id'],
            'engagement_code_id' => ['exists:engagement_codes,id'],
            'description'        => ['']
        ];
    }

    public function session_data()
    {
        $start = new TimeOfDay($this->start_time);
        $end = new TimeOfDay($this->end_time);

        $start_time = Carbon::parse($this->session_date)
                            ->setHours($start->hours)
                            ->setMinutes($start->mins);
        $end_time = Carbon::parse($this->session_date)
                          ->setHours($end->hours)
                          ->setMinutes($end->mins);

        $is_holiday = Holiday::existsFor($start_time);
        $is_make_up_day = MakeUpDay::existsFor($start_time);

        return [
            'start_time'         => $start_time,
            'end_time'           => $end_time,
            'client_id'          => $this->client_id,
            'engagement_code_id' => $this->engagement_code_id,
            'service_period'     => $this->service_period,
            'notes'              => $this->notes,
            'description'        => $this->description,
            'on_holiday'         => $is_holiday,
            'on_make_up_day'     => $is_make_up_day,
        ];
    }
}
