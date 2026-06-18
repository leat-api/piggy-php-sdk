<?php

namespace Piggy\Api\StaticMappers\Loyalty\Rewards;

use Piggy\Api\Models\Loyalty\Rewards\CollectableRewardRedemption;
use stdClass;

class CollectableRewardRedemptionMapper
{
    public static function map(stdClass $data): CollectableRewardRedemption
    {
        return new CollectableRewardRedemption(
            $data->uuid,
            $data->status
        );
    }
}
