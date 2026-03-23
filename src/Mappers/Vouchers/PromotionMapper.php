<?php

namespace Piggy\Api\Mappers\Vouchers;

use Piggy\Api\Mappers\Loyalty\MediaMapper;
use Piggy\Api\Models\Vouchers\Promotion;
use stdClass;

class PromotionMapper
{
    public function map(stdClass $data): Promotion
    {
        if (isset($data->attributes) && is_object($data->attributes)) {
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
            $attributes ?? [],
            $data->type,
            $data->redemptions_per_voucher,
            $media ?? null
        );
    }
}
