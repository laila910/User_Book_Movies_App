<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeAndUpdateMovieRequest extends FormRequest
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
                'name' => 'sometimes|required|min:3|max:255',
                'description' => 'sometimes|required|min:3|max:255',
                'type'=>'sometimes|required',
                'image' => 'image|mimes:jpg,jpeg,png|sometimes|required',
                'ticketPrice'=>'sometimes|required'
            ];
            

        }else{
           
          return [
        'name' => 'required|min:3|max:255',
        // 'email' => 'required|email|unique:users,email,'.$this->user,
        'description' => 'required|min:3|max:255',
        'type'=>'required',
        'image' => 'image|mimes:jpg,jpeg,png|sometimes|required',
        'ticketPrice'=>'required'
           ];
       }
    }
}
