<?php

namespace App\Http\Requests;

use App\Leave\LeaveRequest;
use App\Rules\BusinessHours;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class UserLeaveRequestForm extends FormRequest
{

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
            'start_date' => ['required', 'date'],
            'start_time' => ['required', new BusinessHours()],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'end_time' => ['required', new BusinessHours()],
            'covering_user_id' => ['required', 'exists:users,id'],
            'reason' => [],
            'leave_type' => [Rule::in(['事假', '特別休', '病假', '婚假', '喪假', '公假'])]
        ];
    }

    public function parsedInput()
    {
        $start_hour = intval(substr($this->start_time, 0 ,2));
        $start_mins = intval(substr($this->start_time, 3 ,2));

        $starts = Carbon::parse($this->start_date)->setHour($start_hour)->setMinutes($start_mins);

        $end_hour = intval(substr($this->end_time, 0 ,2));
        $end_mins = intval(substr($this->end_time, 3 ,2));

        $ends = Carbon::parse($this->end_date)->setHour($end_hour)->setMinutes($end_mins);

        return [
            'starts' => $starts,
            'ends' => $ends,
            'reason' => $this->reason,
            'covering_user_id' => $this->covering_user_id,
            'status' => LeaveRequest::SUBMITTED,
            'leave_type' => $this->leave_type,
        ];
    }
}
