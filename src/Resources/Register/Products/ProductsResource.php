<?php

namespace Piggy\Api\Resources\Register\Products;

use Piggy\Api\Exceptions\PiggyRequestException;
use Piggy\Api\Mappers\Products\ProductMapper;
use Piggy\Api\Mappers\Products\ProductsMapper;
use Piggy\Api\Models\Products\Product;
use Piggy\Api\Resources\BaseResource;

class ProductsResource extends BaseResource
{
    /**
     * @var string
     */
    protected $resourceUri = '/api/v3/register/products';

    /**
     * @param array<string, mixed> $params
     *
     * @return Product[]
     *
     * @throws PiggyRequestException
     */
    public function list(array $params = []): array
    {
        $response = $this->client->get($this->resourceUri, $params);

        $mapper = new ProductsMapper();

        return $mapper->map((array) $response->getData());
    }

    /**
     * @param string $externalIdentifier
     * @param string $name
     * @param string|null $description
     * @param array<int, array<string, mixed>>|null $categories
     *
     * @return Product
     *
     * @throws PiggyRequestException
     */
    public function create(string $externalIdentifier, string $name, ?string $description, ?array $categories): Product
    {
        $response = $this->client->post($this->resourceUri, [
            'external_identifier' => $externalIdentifier,
            'name' => $name,
            'description' => $description,
            'categories' => $categories,
        ]);

        $mapper = new ProductMapper();

        return $mapper->map($response->getData());
    }

    /**
     * @param string $uuid
     * @param array<string, mixed> $params
     *
     * @return Product
     *
     * @throws PiggyRequestException
     */
    public function get(string $uuid, array $params = []): Product
    {
        $response = $this->client->get("$this->resourceUri/$uuid", $params);

        $mapper = new ProductMapper();

        return $mapper->map($response->getData());
    }

    /**
     * @param string $externalIdentifier
     *
     * @return Product
     *
     * @throws PiggyRequestException
     */
    public function find(string $externalIdentifier): Product
    {
        $response = $this->client->get("$this->resourceUri/find", [
            'external_identifier' => $externalIdentifier,
        ]);

        $mapper = new ProductMapper();

        return $mapper->map($response->getData());
    }

    /**
     * @param string $externalIdentifier
     * @param string|null $name
     * @param string|null $description
     * @param array<int, array<string, mixed>>|null $categories
     *
     * @return Product
     *
     * @throws PiggyRequestException
     */
    public function findOrCreate(string $externalIdentifier, ?string $name, ?string $description, ?array $categories): Product
    {
        $response = $this->client->post("$this->resourceUri/find-or-create", [
            'external_identifier' => $externalIdentifier,
            'name' => $name,
            'description' => $description,
            'categories' => $categories,
        ]);

        $mapper = new ProductMapper();

        return $mapper->map($response->getData());
    }

    /**
     * @param string $uuid
     * @param string|null $externalIdentifier
     * @param string|null $name
     * @param string|null $description
     * @param array<int, array<string, mixed>>|null $categories
     *
     * @return Product
     *
     * @throws PiggyRequestException
     */
    public function update(string $uuid, ?string $externalIdentifier, ?string $name, ?string $description, ?array $categories): Product
    {
        $response = $this->client->put("$this->resourceUri/$uuid", [
            'external_identifier' => $externalIdentifier,
            'name' => $name,
            'description' => $description,
            'categories' => $categories,
        ]);

        $mapper = new ProductMapper();

        return $mapper->map($response->getData());
    }

    /**
     * @param string $uuid
     * @param array<string, mixed> $params
     *
     * @return mixed
     *
     * @throws PiggyRequestException
     */
    public function delete(string $uuid, array $params = [])
    {
        $response = $this->client->destroy("$this->resourceUri/$uuid", $params);

        return $response->getData();
    }

    /**
     * @param array<string, mixed> $products
     *
     * @return array<string, mixed>
     *
     * @throws PiggyRequestException
     */
    public function batch(array $products)
    {
        $response = $this->client->post("$this->resourceUri/batch", [
            'products' => $products,
        ]);

        return $response->getData();
    }
}
