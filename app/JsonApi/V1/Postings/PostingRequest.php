<?php

namespace App\JsonApi\V1\Postings;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class PostingRequest extends ResourceRequest
{
    public function rules(): array
    {
        return [
            'source' => ['required', 'string'],
            'sourceId' => ['required', 'string'],
            'employmentType' => ['required', 'string'],
            'workMode' => ['required', 'string'],
            'url' => ['required', 'url'],
            'company' => ['required', 'string'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'status' => ['required', 'string'],
            'coverLetter' => ['nullable', 'string'],
        ];
    }
}
