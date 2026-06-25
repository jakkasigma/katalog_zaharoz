<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(['pending', 'processing', 'shipped', 'delivered', 'cancelled'])],
            'tracking_number' => ['nullable', 'string', 'max:255', Rule::requiredIf($this->input('status') === 'shipped')],
        ];
    }

    /**
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $order = $this->route('order');

                if (! $order) {
                    return;
                }

                $allowed = [
                    'pending' => ['processing', 'cancelled'],
                    'processing' => ['shipped', 'cancelled'],
                    'shipped' => ['delivered'],
                    'delivered' => [],
                    'cancelled' => [],
                ];

                if (! in_array($this->input('status'), $allowed[$order->status] ?? [], true)) {
                    $validator->errors()->add('status', 'Perubahan status pesanan tidak valid.');
                }
            },
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'status.required' => 'Status pesanan wajib dipilih.',
            'status.in' => 'Status pesanan tidak valid.',
            'tracking_number.required' => 'Nomor resi wajib diisi saat pesanan dikirim.',
        ];
    }
}
