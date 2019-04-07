<?php

namespace App\Http\Requests;

use App\Rules\StartEndTime;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class CreateSessionForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'session_date' => ['required', 'date'],
            'start_time' => [new StartEndTime()],
            'end_time' => [new StartEndTime(request('start_time'))],
            'service_period' => ['required'],
            'client_id' => ['exists:clients,id'],
            'engagement_code_id' => ['exists:engagement_codes,id'],
            'description' => ['required']
        ];
    }

    public function session_data()
    {
        $start = explode(":", $this->start_time);
        $end = explode(":", $this->end_time);

        $start_time = Carbon::parse($this->session_date)->startOfDay()->setHours(intval($start[0]))->setMinutes(intval($start[1]));
        $end_time = Carbon::parse($this->session_date)->startOfDay()->setHours(intval($end[0]))->setMinutes(intval($end[1]));

        return [
            'start_time'         => $start_time,
            'end_time'           => $end_time,
            'client_id'          => $this->client_id,
            'engagement_code_id' => $this->engagement_code_id,
            'service_period'     => $this->service_period,
            'notes'              => $this->notes,
            'description'        => $this->description,
        ];
    }
}
