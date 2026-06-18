<?php

namespace Piggy\Api\Mappers\Loyalty\Rewards;

use Piggy\Api\Models\Loyalty\Rewards\CollectableRewardRedemption;
use stdClass;

class CollectableRewardRedemptionMapper
{
    public function map(stdClass $data): CollectableRewardRedemption
    {
        return new CollectableRewardRedemption(
            $data->uuid,
            $data->status
        );
    }
}
