<?php

namespace App\JsonApi\V1\Users;

use App\Models\User;
use Illuminate\Http\Request;
use LaravelJsonApi\Core\Resources\JsonApiResource;

/**
 * @property User $resource
 */
class UserResource extends JsonApiResource
{
    /**
     * Get the resource's attributes.
     *
     * @param Request|null $request
     * @return iterable
     */
    public function attributes($request): iterable
    {
        return [
            'name'      => $this->resource->name,
            'title'     => $this->resource->title,
            'address'   => $this->resource->address,
            'city'      => $this->resource->city,
            'state'     => $this->resource->state,
            'country'   => $this->resource->country,
            'zip'       => $this->resource->zip,
            'phone'     => $this->resource->phone,
            'email'     => $this->resource->email,
            'createdAt' => $this->resource->created_at,
            'updatedAt' => $this->resource->updated_at,
        ];
    }

    /**
     * Get the resource's relationships.
     *
     * @param Request|null $request
     * @return iterable
     */
    public function relationships($request): iterable
    {
        return [
            // @TODO
        ];
    }

}
