<?php

namespace Piggy\Api\Models\Orders;

use GuzzleHttp\Exception\GuzzleException;
use Piggy\Api\ApiClient;
use Piggy\Api\Exceptions\MaintenanceModeException;
use Piggy\Api\Exceptions\PiggyRequestException;
use Piggy\Api\StaticMappers\Orders\OrderReturnMapper;
use stdClass;

class OrderReturn
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var stdClass
     */
    protected $order;

    /**
     * @var LineItemReturn[]
     */
    protected $lineItemReturns = [];

    /**
     * @var SubLineItemReturn[]
     */
    protected $subLineItemReturns = [];

    /**
     * @var string
     */
    const resourceUri = '/api/v3/oauth/clients/order-returns';

    /**
     * @param LineItemReturn[] $lineItemReturns
     * @param SubLineItemReturn[] $subLineItemReturns
     */
    public function __construct(
        string $uuid,
        string $status,
        stdClass $order,
        array $lineItemReturns = [],
        array $subLineItemReturns = []
    )
    {
        $this->uuid = $uuid;
        $this->status = $status;
        $this->order = $order;
        $this->lineItemReturns = $lineItemReturns;
        $this->subLineItemReturns = $subLineItemReturns;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return stdClass
     */
    public function getOrder(): stdClass
    {
        return $this->order;
    }

    /**
     * @return LineItemReturn[]
     */
    public function getLineItemReturns(): array
    {
        return $this->lineItemReturns;
    }

    /**
     * @return SubLineItemReturn[]
     */
    public function getSubLineItemReturns(): array
    {
        return $this->subLineItemReturns;
    }

    /**
     * @param array<string, mixed> $body
     *
     * @return OrderReturn
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function create(array $body): OrderReturn
    {
        $response = ApiClient::post(self::resourceUri, $body);

        return OrderReturnMapper::map($response->getData());
    }

    /**
     * @param string $uuid
     * @param array<string, mixed> $body
     *
     * @return stdClass
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function process(string $uuid, array $body = []): stdClass
    {
        $response = ApiClient::post(self::resourceUri."/$uuid/process", $body);

        return $response->getData();
    }


    /**
     * @param array<string, mixed> $body
     *
     * @return array<string, mixed>
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function createAndProcess(array $body): array
    {
        $response = ApiClient::post(self::resourceUri."/create-and-process", $body);

        return [
            'return' => OrderReturnMapper::map($response->getData()->return),
            'result' => $response->getData()->result,
        ];
    }
}
