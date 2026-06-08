<?php

namespace Piggy\Api\Resources\OAuth\Orders;

use Piggy\Api\Exceptions\PiggyRequestException;
use Piggy\Api\Mappers\Orders\OrderMapper;
use Piggy\Api\Mappers\Orders\OrdersMapper;
use Piggy\Api\Models\Orders\Order;
use Piggy\Api\Resources\BaseResource;
use stdClass;

class OrdersResource extends BaseResource
{
    /**
     * @var string
     */
    protected $resourceUri = '/api/v3/oauth/clients/orders';

    /**
     * @param array<string, mixed> $params
     *
     * @return Order[]
     *
     * @throws PiggyRequestException
     */
    public function list(array $params = []): array
    {
        $response = $this->client->get($this->resourceUri, $params);

        $mapper = new OrdersMapper();

        return $mapper->map($response->getData());
    }

    /**
     * @param string $uuid
     * @param array<string, mixed> $params
     *
     * @return Order
     *
     * @throws PiggyRequestException
     */
    public function get(string $uuid, array $params = []): Order
    {
        $response = $this->client->get($this->resourceUri."/$uuid", $params);

        $mapper = new OrderMapper();

        return $mapper->map($response->getData());
    }

    /**
     * @param array<string, mixed> $params
     *
     * @return Order
     *
     * @throws PiggyRequestException
     */
    public function find(array $params): Order
    {
        $response = $this->client->get($this->resourceUri."/find", $params);

        $mapper = new OrderMapper();

        return $mapper->map($response->getData());
    }

    /**
     * @param array<string, mixed> $body
     *
     * @return Order
     *
     * @throws PiggyRequestException
     */
    public function create(array $body): Order
    {
        $response = $this->client->post($this->resourceUri, $body);

        $mapper = new OrderMapper();

        return $mapper->map($response->getData());
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

        $mapper = new OrderMapper();

        return [
            'order' => $mapper->map($response->getData()->order),
            'result' => $response->getData()->result,
        ];
    }

    /**
     * @param array<string, mixed> $body
     *
     * @return stdClass
     *
     * @throws PiggyRequestException
     */
    public function calculate(array $body): stdClass
    {
        $response = $this->client->post($this->resourceUri."/simulate", $body);

        return $response->getData();
    }
}
