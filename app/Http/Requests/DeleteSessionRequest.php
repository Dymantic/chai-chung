<?php

namespace App\Http\Requests;

use App\Time\Session;
use Illuminate\Foundation\Http\FormRequest;

class DeleteSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $session = $this->route('session');
        return $this->user()->is($session->user) || $this->user()->is_manager;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

}
