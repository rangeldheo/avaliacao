<?php

namespace App\Http\Requests\User;

use App\Services\ActivationServices;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserStoreRequest extends FormRequest
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
            'name'     => 'required|min:3|max:80|string',
            'email'    => 'required|string|email:rfc,dns|unique:users,email',
            'password' => 'required|min:3|max:80|confirmed',
            'password_confirmation' => 'required|min:3|max:80'
        ];
    }

    public function prepareForValidation()
    {
        $input = $this->input();
        if ($this->has('email')) {
            $input['remember_token'] = Hash::make(Str::random(10));
            $input['activation_hash'] = ActivationServices::hashGenerate($input['email']);
            $input['activation_expires'] = Carbon::now()->addHour(1);
        }
        $this->replace($input);
    }
}