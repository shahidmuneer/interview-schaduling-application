<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
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
            'address_1' => 'required|max:155',
            'address_2' => 'max:155',
            'city_town' => 'required|max:55',
            'state' => 'required|max:5',
            'zip_code' => 'required|numeric|max:9999999999',
        ];
    }
}
