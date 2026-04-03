<?php

namespace App\Http\Requests\Api\V1;

class UpdateSiteContentRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'contents' => ['required', 'array'],
            'contents.*.key' => ['required', 'string', 'exists:site_contents,key'],
            'contents.*.value' => ['nullable'],
        ];
    }
}
