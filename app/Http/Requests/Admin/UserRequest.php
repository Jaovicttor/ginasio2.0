<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        switch ($this->method()){
            case 'POST':
                return $this->store();
            break;
            case 'PUT' || 'PATCH':
                return $this->update();
            break; 
        }

    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        /*$this->merge([
            'username' => Helper::onlyDigitsString($this->username),
        ]);*/
    }


    protected function store()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required'],
            'mail' => ['required']
        ];
    }
}
