<?php

namespace Piggy\Api\Models\Products;

use GuzzleHttp\Exception\GuzzleException;
use Piggy\Api\ApiClient;
use Piggy\Api\Exceptions\MaintenanceModeException;
use Piggy\Api\Exceptions\PiggyRequestException;
use Piggy\Api\Http\Responses\Response;
use Piggy\Api\StaticMappers\Products\ProductMapper;
use Piggy\Api\StaticMappers\Products\ProductsMapper;
use Piggy\Api\Models\Categories\Category;

class Product
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var string
     */
    protected $externalIdentifier;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $description;

    /**
     * @var ?Category[]
     */
    protected $categories;

    /**
     * @var string
     */
    const resourceUri = '/api/v3/oauth/clients/products';

    /** @param Category[]|null $categories */
    public function __construct(
        string $uuid,
        string $externalIdentifier,
        string $name,
        ?string $description,
        ?array $categories
    ) {
        $this->uuid = $uuid;
        $this->externalIdentifier = $externalIdentifier;
        $this->name = $name;
        $this->description = $description;
        $this->categories = $categories;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getExternalIdentifier(): string
    {
        return $this->externalIdentifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return ?Category[]
     */
    public function getCategories(): ?array
    {
        return $this->categories;
    }

    /**
     * @param array<string, mixed> $params
     *
     * @return Product[]
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function list(array $params = []): array
    {
        $response = ApiClient::get(self::resourceUri, $params);

        return ProductsMapper::map($response->getData());
    }

    /**
     * @param array<string, mixed> $body
     *
     * @return Product
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function create(array $body): Product
    {
        $response = ApiClient::post(self::resourceUri, $body);

        return ProductMapper::map($response->getData());
    }

    /**
     * @param string $uuid
     * @param array<string, mixed> $params
     *
     * @return Product
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function get(string $uuid, array $params = []): Product
    {
        $response = ApiClient::get(self::resourceUri."/$uuid", $params);

        return ProductMapper::map($response->getData());
    }

    /**
     * @param array<string, mixed> $params
     *
     * @return Product
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function find(array $params): Product
    {
        $response = ApiClient::get(self::resourceUri."/find", $params);

        return ProductMapper::map($response->getData());
    }

    /**
     * @param array<string, mixed> $body
     *
     * @return Product
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function findOrCreate(array $body): Product
    {
        $response = ApiClient::post(self::resourceUri."/find-or-create", $body);

        return ProductMapper::map($response->getData());
    }

    /**
     * @param string $uuid
     * @param array<string, mixed> $body
     *
     * @return Product
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public function update(string $uuid, array $body): Product
    {
        $response = ApiClient::put(self::resourceUri."/$uuid", $body);

        return ProductMapper::map($response->getData());
    }

    /**
     * @param string $uuid
     * @param array<string, mixed> $params
     *
     * @return Response
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function delete(string $uuid, array $params = []): Response
    {
        return ApiClient::delete(self::resourceUri."/$uuid", $params);
    }

    /**
     * @param array<string, mixed> $body
     *
     * @return array<string, string>
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function batch(array $body): array
    {
        $response = ApiClient::post(self::resourceUri."/batch", $body);

        return $response->getData();
    }
}
