<?php

namespace App\JsonApi\Filters;

use Illuminate\Database\Eloquent\Builder;
use LaravelJsonApi\Eloquent\Contracts\Filter;
use LaravelJsonApi\Eloquent\Filters\Concerns\DeserializesValue;
use LaravelJsonApi\Eloquent\Filters\Concerns\IsSingular;

final class ContainsFilter implements Filter
{
    use DeserializesValue;
    use IsSingular;

    public function __construct(
        private string $name,
        private ?string $column = null,
    ) {}

    public static function make(string $name, ?string $column = null): self
    {
        return new self($name, $column);
    }

    public function key(): string
    {
        return $this->name;
    }

    public function apply($query, $value)
    {
        /** @var Builder $query */
        $term = $this->deserialize($value);

        if (!is_string($term) || $term === '') {
            return $query;
        }

        $column = $this->column ?? $this->name;
        $qualified = $query->getModel()->qualifyColumn($column);

        // escape LIKE wildcards so the input is treated literally
        $escaped = addcslashes($term, "%_\\");
        return $query->where($qualified, 'like', "%{$escaped}%");
    }
}
