<?php

namespace App\Http\Requests;

use App\Time\DateRange;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class DatedQueryRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            //
        ];
    }

    public function dateRange()
    {
        $from = Carbon::parse($this->get('from'));
        $to = Carbon::parse($this->get('to'));
        return new DateRange($from, $to);
    }
}
