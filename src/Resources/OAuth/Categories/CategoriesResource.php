<?php

namespace Piggy\Api\Resources\OAuth\Categories;

use Piggy\Api\Exceptions\PiggyRequestException;
use Piggy\Api\Mappers\Categories\CategoryMapper;
use Piggy\Api\Mappers\Categories\CategoriesMapper;
use Piggy\Api\Models\Categories\Category;
use Piggy\Api\Resources\BaseResource;

class CategoriesResource extends BaseResource
{
    /**
     * @var string
     */
    protected $resourceUri = '/api/v3/oauth/clients/product-categories';

    /**
     * @param array<string, mixed> $params
     *
     * @return Category[]
     *
     * @throws PiggyRequestException
     */
    public function list(array $params = []): array
    {
        $response = $this->client->get($this->resourceUri, $params);

        $mapper = new CategoriesMapper();

        return $mapper->map((array) $response->getData());
    }

    /**
     * @param string $externalIdentifier
     * @param string $name
     *
     * @return Category
     *
     * @throws PiggyRequestException
     */
    public function create(string $externalIdentifier, string $name): Category
    {
        $response = $this->client->post($this->resourceUri, [
            'external_identifier' => $externalIdentifier,
            'name' => $name,
        ]);

        $mapper = new CategoryMapper();

        return $mapper->map($response->getData());
    }

    /**
     * @param string $uuid
     * @param array<string, mixed> $params
     *
     * @return Category
     *
     * @throws PiggyRequestException
     */
    public function get(string $uuid, array $params = []): Category
    {
        $response = $this->client->get("$this->resourceUri/$uuid", $params);

        $mapper = new CategoryMapper();

        return $mapper->map($response->getData());
    }

    /**
     * @param string $externalIdentifier
     *
     * @return Category
     *
     * @throws PiggyRequestException
     */
    public function find(string $externalIdentifier): Category
    {
        $response = $this->client->get("$this->resourceUri/find", [
            'external_identifier' => $externalIdentifier,
        ]);

        $mapper = new CategoryMapper();

        return $mapper->map($response->getData());
    }

    /**
     * @param string $externalIdentifier
     * @param string|null $name
     *
     * @return Category
     *
     * @throws PiggyRequestException
     */
    public function findOrCreate(string $externalIdentifier, ?string $name): Category
    {
        $response = $this->client->post("$this->resourceUri/find-or-create", [
            'external_identifier' => $externalIdentifier,
            'name' => $name,
        ]);

        $mapper = new CategoryMapper();

        return $mapper->map($response->getData());
    }

    /**
     * @param string $uuid
     * @param string|null $externalIdentifier
     * @param string|null $name
     *
     * @return Category
     *
     * @throws PiggyRequestException
     */
    public function update(string $uuid, ?string $externalIdentifier, ?string $name): Category
    {
        $response = $this->client->put("$this->resourceUri/$uuid", [
            'external_identifier' => $externalIdentifier,
            'name' => $name,
        ]);

        $mapper = new CategoryMapper();

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
     * @param array<string, mixed> $categories
     *
     * @return array<string, mixed>
     *
     * @throws PiggyRequestException
     */
    public function batch(array $categories)
    {
        $response = $this->client->post("$this->resourceUri/batch", [
            'categories' => $categories,
        ]);

        return $response->getData();
    }
}
