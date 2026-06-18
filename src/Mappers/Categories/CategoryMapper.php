<?php

namespace Piggy\Api\Mappers\Categories;

use Piggy\Api\Models\Categories\Category;
use stdClass;

class CategoryMapper
{
    public function map(stdClass $data): Category
    {
        return new Category(
            $data->uuid ?? '',
            $data->external_identifier,
            $data->name
        );
    }
}
