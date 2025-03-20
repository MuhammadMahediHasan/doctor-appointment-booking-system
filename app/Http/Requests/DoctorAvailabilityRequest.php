<?php

namespace App\Http\Requests;

use App\Rules\TimeSlotRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DoctorAvailabilityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'time_slots' => 'required|array|min:1',
            'time_slots.*' => [
                'required',
                'string',
                new TimeSlotRule(),
            ],
        ];
    }
}
