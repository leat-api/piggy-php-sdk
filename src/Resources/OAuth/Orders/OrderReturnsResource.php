<?php

namespace Piggy\Api\Resources\OAuth\Orders;

use Piggy\Api\Exceptions\PiggyRequestException;
use Piggy\Api\Models\Orders\OrderReturn;
use Piggy\Api\Resources\BaseResource;
use Piggy\Api\StaticMappers\Orders\OrderReturnMapper;
use stdClass;

class OrderReturnsResource extends BaseResource
{
    /**
     * @var string
     */
    protected $resourceUri = '/api/v3/oauth/clients/order-returns';

    /**
     * @param array<string, mixed> $body
     *
     * @return OrderReturn
     *
     * @throws PiggyRequestException
     */
    public function create(array $body): OrderReturn
    {
        $response = $this->client->post($this->resourceUri, $body);

        return OrderReturnMapper::map($response->getData());
    }

    /**
     * @param string $uuid
     * @param array<string, mixed> $body
     *
     * @return stdClass
     *
     * @throws PiggyRequestException
     */
    public function process(string $uuid, array $body = []): stdClass
    {
        $response = $this->client->post($this->resourceUri."/$uuid/process", $body);

        return $response->getData();
    }


    /**
     * @param array<string, mixed> $body
     *
     * @return array<string, mixed>
     *
     * @throws PiggyRequestException
     */
    public function createAndProcess(array $body): array
    {
        $response = $this->client->post($this->resourceUri."/create-and-process", $body);

        return [
            'return' => OrderReturnMapper::map($response->getData()->return),
            'result' => $response->getData()->result,
        ];
    }
}
