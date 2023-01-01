<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeAndUpdateUserRequest extends FormRequest
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
        if($this->method()=='PUT'){
           
            return [
                'username' => 'sometimes|required|min:3|max:255',
                'email' => 'sometimes|required|email',
                'password'=>'sometimes|required|min:3|max:255',
                'image' => 'image|mimes:jpg,jpeg,png|sometimes|required'
            ];
            

        }else{
           
          return [
        'username' => 'required|min:3|max:255',
        'email' => 'required|email',
        'password'=>'required|min:3|max:255',
        'image' => 'image|mimes:jpg,jpeg,png|sometimes|required'
           ];
       }
    }
}
