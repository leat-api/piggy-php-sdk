<?php

namespace Piggy\Api\StaticMappers\Vouchers;

use Piggy\Api\Mappers\Loyalty\MediaMapper;
use Piggy\Api\Models\Vouchers\Promotion;

class PromotionMapper
{
    public static function map($data): Promotion
    {
        if (is_array($data->attributes)) {
            $attributes = $data->attributes;
        } else {
            $attributes = get_object_vars($data->attributes);
        }

        if (isset($data->media)) {
            $media = (new MediaMapper)->map($data->media);
        }

        return new Promotion(
            $data->uuid,
            $data->name,
            $data->description,
            $data->voucher_limit ?? null,
            $data->limit_per_contact ?? null,
            $data->expiration_duration ?? null,
            isset($data->attributes) ? $attributes : [],
            $data->type,
            $data->redemptions_per_voucher,
            $media ?? null
        );
    }
}
