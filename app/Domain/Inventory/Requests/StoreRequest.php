<?php

namespace App\Domain\Inventory\Requests;

use App\Domain\Shared\Traits\HandlesFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    use HandlesFailedValidation;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|numeric|exists:products,id',
            'warehouse_id' => 'required|numeric|exists:warehouses,id',
            'quantity' => 'required|numeric',
        ];
    }
}
