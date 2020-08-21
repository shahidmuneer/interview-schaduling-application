<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerStoreRequest extends FormRequest
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
            'employment' => 'required',
            'residence' => 'required',
            'available_hours' => 'required|max:32',
            'good_fit' => 'required|max:255'
        ];
    }
}
