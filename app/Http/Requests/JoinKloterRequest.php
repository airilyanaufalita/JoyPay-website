<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JoinKloterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'member_name' => 'required|string|max:255|min:3',
            'phone_number' => 'required|string|regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'
        ];
    }

    public function messages()
    {
        return [
            'member_name.required' => 'Nama lengkap wajib diisi',
            'member_name.min' => 'Nama minimal 3 karakter',
            'phone_number.required' => 'Nomor WhatsApp wajib diisi',
            'phone_number.regex' => 'Format nomor WhatsApp tidak valid (contoh: 08123456789)'
        ];
    }
}