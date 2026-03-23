<?php

namespace Piggy\Api\Models\Vouchers;

use GuzzleHttp\Exception\GuzzleException;
use Piggy\Api\ApiClient;
use Piggy\Api\Exceptions\MaintenanceModeException;
use Piggy\Api\Exceptions\PiggyRequestException;
use Piggy\Api\Models\Loyalty\Media;
use Piggy\Api\StaticMappers\Vouchers\PromotionMapper;
use Piggy\Api\StaticMappers\Vouchers\PromotionsMapper;

class Promotion
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string|null
     */
    protected $type;

    /**
     * @var int|null
     */
    protected $redemptions_per_voucher;

    /**
     * @var int|null
     */
    protected $voucher_limit;

    /**
     * @var int|null
     */
    protected $limit_per_contact;

    /**
     * @var int|null
     */
    protected $expiration_duration;

    /**
     * @var mixed[]
     */
    protected $attributes;

    /**
     * @var Media|null
     */
    protected $media;

    /**
     * @var string
     */
    const resourceUri = '/api/v3/oauth/clients/promotions';

    /**
     * @param  mixed[]  $attributes
     */
    public function __construct(
        string $uuid,
        string $name,
        string $description,
        ?int $voucher_limit = null,
        ?int $limit_per_contact = null,
        ?int $expiration_duration = null,
        array $attributes = [],
        ?string $type = null,
        ?int $redemptions_per_voucher = null,
        ?Media $media = null
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->description = $description;
        $this->voucher_limit = $voucher_limit;
        $this->limit_per_contact = $limit_per_contact;
        $this->expiration_duration = $expiration_duration;
        $this->attributes = $attributes;
        $this->type = $type;
        $this->redemptions_per_voucher = $redemptions_per_voucher;
        $this->media = $media;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getRedemptionsPerVoucher(): ?int
    {
        return $this->redemptions_per_voucher;
    }

    public function getVoucherLimit(): ?int
    {
        return $this->voucher_limit;
    }

    public function getLimitPerContact(): ?int
    {
        return $this->limit_per_contact;
    }

    public function getExpirationDuration(): ?int
    {
        return $this->expiration_duration;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return mixed[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    /**
     * @param  mixed[]  $body
     *
     * @throws MaintenanceModeException|GuzzleException|PiggyRequestException
     */
    public static function create(array $body): Promotion
    {
        $response = ApiClient::post(self::resourceUri, $body);

        return PromotionMapper::map($response->getData());
    }

    /**
     * @param  mixed[]  $params
     * @return Promotion[]
     *
     * @throws MaintenanceModeException|GuzzleException|PiggyRequestException
     */
    public static function list(array $params = []): array
    {
        $response = ApiClient::get(self::resourceUri, $params);

        return PromotionsMapper::map((array) $response->getData());
    }
}
