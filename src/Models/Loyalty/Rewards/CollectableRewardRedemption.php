<?php

namespace Piggy\Api\Models\Loyalty\Rewards;

class CollectableRewardRedemption
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var string
     */
    protected $status;

    public function __construct(
        string $uuid,
        string $status
    ) {
        $this->uuid = $uuid;
        $this->status = $status;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
