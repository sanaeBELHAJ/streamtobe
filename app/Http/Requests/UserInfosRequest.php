<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserInfosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pseudo' => 'required',
            'email' => 'required|email',
            'name' => 'string',
            'password' => 'confirmed',
            'pictureAccount' => 'image|mimes:jpg,png,jpeg,gif|max:2000',
            'country' => 'required|exists:stb_countries,id'
        ];
    }
}
