<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'type' => 'required|integer|in:1,2,3',
            'transport_mode' => 'required|string|in:air,land,sea',
            'product' => 'required|string|max:255',
            'origin_country' => 'required|string|max:255',
            'destination_country' => 'required|string|max:255',
            'status' => 'required|string|in:new,in_process,completed',
            'ticket_id' => 'nullable|integer|exists:tickets,id',
            // Rules for messages
            'content' => 'required|string',
            'message_type' => 'required|in:user,agent',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx',
        ];
    }
}
