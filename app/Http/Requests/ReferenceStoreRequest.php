<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReferenceStoreRequest extends FormRequest
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
            'full_name_ref_1' => 'required|max:32',
            'phone_number_ref_1' => 'required|max:14',
            'relationship_ref_1' => 'required|max:155',
            'full_name_ref_2' => 'required|max:32',
            'phone_number_ref_2' => 'required|max:14',
            'relationship_ref_2' => 'required|max:155',
            'full_name_ref_3' => 'required|max:32',
            'phone_number_ref_3' => 'required|max:14',
            'relationship_ref_3' => 'required|max:155',
        ];
    }
}
