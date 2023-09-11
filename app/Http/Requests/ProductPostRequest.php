<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows("products.alter");
    }

    public function prepareForValidation(): void
    {
        $this->merge(["slug" => Str::slug($this->title)]);
    }

    public function rules(): array
    {
        /** @var \App\Models\User */
        $user = auth()->user();
        return [
            "title" => "required",
            "slug" => ["required", "unique:products"],
            // "price" => ["numeric",],
            // "cost" => ["numeric",],
            // "quantity" => "integer",
            "category_id" => [
                "integer",
                Rule::in($user->categories()->pluck("id"))
            ],
            "images.*" => ["image"]
        ];
    }

    public function messages(): array
    {
        return [
            "title" => "Please Provide a Title",
            "slug.unique" => "Product Already exists"
        ];
    }
}
