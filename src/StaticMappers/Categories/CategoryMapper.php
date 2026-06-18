<?php

namespace Piggy\Api\StaticMappers\Categories;

use Piggy\Api\Models\Categories\Category;
use stdClass;

class CategoryMapper
{
    public static function map(stdClass $data): Category
    {
        return new Category(
            $data->uuid ?? '',
            $data->external_identifier,
            $data->name
        );
    }
}
