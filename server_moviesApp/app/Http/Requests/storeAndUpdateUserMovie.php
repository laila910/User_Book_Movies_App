<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeAndUpdateUserMovie extends FormRequest
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
                'movie_id' => 'sometimes|required|exists:App\Models\Movie,id',
                'datetime' => 'sometimes|required',  
                'ticketsNumbers'=>'sometimes|required',
                'user_id'=>'sometimes|required|exists:App\Models\User,id'

              
            ];
            

        }else{
           
          return [
            'movie_id'=>'sometimes|required|exists:App\Models\Movie,id',
        'datetime' => 'sometimes|required',
        'ticketsNumbers'=>'sometimes|required',
        'user_id'=>'sometimes|required|exists:App\Models\User,id'
           ];
       }
    }
}
