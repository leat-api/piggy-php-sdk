<?php

namespace Piggy\Api\Models\Categories;

use GuzzleHttp\Exception\GuzzleException;
use Piggy\Api\ApiClient;
use Piggy\Api\Exceptions\MaintenanceModeException;
use Piggy\Api\Exceptions\PiggyRequestException;
use Piggy\Api\Http\Responses\Response;
use Piggy\Api\StaticMappers\Categories\CategoryMapper;
use Piggy\Api\StaticMappers\Categories\CategoriesMapper;

class Category
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
     * @var string
     */
    const resourceUri = '/api/v3/oauth/clients/product-categories';

    public function __construct(
        string $uuid,
        string $externalIdentifier,
        string $name
    ) {
        $this->uuid = $uuid;
        $this->externalIdentifier = $externalIdentifier;
        $this->name = $name;
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

    /**
     * @param array<string, mixed> $params
     *
     * @return Category[]
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function list(array $params = []): array
    {
        $response = ApiClient::get(self::resourceUri, $params);

        return CategoriesMapper::map($response->getData());
    }

    /**
     * @param array<string, mixed> $body
     *
     * @return Category
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function create(array $body): Category
    {
        $response = ApiClient::post(self::resourceUri, $body);

        return CategoryMapper::map($response->getData());
    }

    /**
     * @param string $uuid
     * @param array<string, mixed> $params
     *
     * @return Category
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function get(string $uuid, array $params = []): Category
    {
        $response = ApiClient::get(self::resourceUri."/$uuid", $params);

        return CategoryMapper::map($response->getData());
    }

    /**
     * @param array<string, mixed> $params
     *
     * @return Category
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function find(array $params): Category
    {
        $response = ApiClient::get(self::resourceUri."/find", $params);

        return CategoryMapper::map($response->getData());
    }

    /**
     * @param array<string, mixed> $body
     *
     * @return Category
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function findOrCreate(array $body): Category
    {
        $response = ApiClient::post(self::resourceUri."/find-or-create", $body);

        return CategoryMapper::map($response->getData());
    }

    /**
     * @param string $uuid
     * @param array<string, mixed> $body
     *
     * @return Category
     *
     * @throws GuzzleException|MaintenanceModeException|PiggyRequestException
     */
    public static function update(string $uuid, array $body): Category
    {
        $response = ApiClient::put(self::resourceUri."/$uuid", $body);

        return CategoryMapper::map($response->getData());
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
