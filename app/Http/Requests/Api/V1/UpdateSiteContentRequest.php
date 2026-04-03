<?php

namespace App\Http\Requests\Api\V1;

class UpdateSiteContentRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Standard text updates
            'key' => ['required', 'string', 'exists:site_contents,key'],
            'value' => ['nullable', 'string'],
            
            // Explicit image fields for frontend clarity
            'file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'files' => ['nullable', 'array'],
            'files.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'file.image' => 'يجب أن يكون الملف صورة.',
            'file.mimes' => 'يجب أن تكون الصورة بصيغة (jpg, jpeg, png, webp).',
            'files.*.image' => 'جميع الملفات المرفوعة يجب أن تكون صوراً.',
        ];
    }
}
