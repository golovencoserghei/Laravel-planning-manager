<?php

namespace App\Http\Requests;

use App\Models\Congregation;
use App\Models\Stand;
use App\Models\StandPublishers;
use App\Models\StandTemplate;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

/**
 * @property-read int $standTemplateId
 * @property-read int $publisher
 * @property-read int $partner
 * @property-read int $time
 */
class StandPublishersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'standTemplateId' => [
                'required',
                Rule::exists(StandTemplate::TABLE, 'id')
            ],
            'publisher' => [
                'required',
                Rule::exists(User::TABLE, 'id')
            ],
            'partner' => [
                'required',
                Rule::exists(User::TABLE, 'id')
            ],
            'time' => [
                'required',
                'integer',
                'between:1,23',
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['status' => false, 'message' => $validator->errors()], 422));
    }
}
