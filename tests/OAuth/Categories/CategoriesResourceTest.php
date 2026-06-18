<?php

namespace Piggy\Api\Tests\OAuth\Categories;

use Piggy\Api\Exceptions\PiggyRequestException;
use Piggy\Api\Tests\OAuthTestCase;

class CategoriesResourceTest extends OAuthTestCase
{
    /** @test
     *
     * @throws PiggyRequestException
     */
    public function it_returns_a_list_of_categories(): void
    {
        $this->addExpectedResponse([
            [
                'uuid' => '123',
                'external_identifier' => '123',
                'name' => 'Category 1 name',
            ],
            [
                'uuid' => '456',
                'external_identifier' => '456',
                'name' => 'Category 2 name',
            ],
        ]);

        $categories = $this->mockedClient->categories->list();

        $this->assertEquals('123', $categories[0]->getUuid());
        $this->assertEquals('123', $categories[0]->getExternalIdentifier());;
        $this->assertEquals('Category 1 name', $categories[0]->getName());

        $this->assertEquals('456', $categories[1]->getUuid());
        $this->assertEquals('456', $categories[1]->getExternalIdentifier());;
        $this->assertEquals('Category 2 name', $categories[1]->getName());
    }

    /** @test
     *
     * @throws PiggyRequestException
     */
    public function it_can_create_a_category(): void
    {
        $this->addExpectedResponse([
            'uuid' => '123',
            'external_identifier' => '123',
            'name' => 'Category 1 name',
        ]);

        $category = $this->mockedClient->categories->create(
            '123',
            'Category 1 name'
        );

        $this->assertEquals('123', $category->getUuid());
        $this->assertEquals('123', $category->getExternalIdentifier());;
        $this->assertEquals('Category 1 name', $category->getName());
    }

    /** @test
     *
     * @throws PiggyRequestException
     */
    public function it_defaults_uuid_to_empty_string_when_missing(): void
    {
        // Order responses (e.g. create-and-process) serialize categories
        // without a uuid; the mapper must not blow up.
        $this->addExpectedResponse([
            'external_identifier' => '123',
            'name' => 'Category 1 name',
        ]);

        $category = $this->mockedClient->categories->create(
            '123',
            'Category 1 name'
        );

        $this->assertEquals('', $category->getUuid());
        $this->assertEquals('123', $category->getExternalIdentifier());
        $this->assertEquals('Category 1 name', $category->getName());
    }

    /** @test
     *
     * @throws PiggyRequestException
     */
    public function it_can_get_a_category(): void
    {
        $this->addExpectedResponse([
            'uuid' => '123',
            'external_identifier' => '123',
            'name' => 'Category 1 name',
        ]);

        $category = $this->mockedClient->categories->get('123');

        $this->assertEquals('123', $category->getUuid());
        $this->assertEquals('123', $category->getExternalIdentifier());;
        $this->assertEquals('Category 1 name', $category->getName());
    }

    /** @test
     *
     * @throws PiggyRequestException
     */
    public function it_can_find_a_category(): void
    {
        $this->addExpectedResponse([
            'uuid' => '123',
            'external_identifier' => '123',
            'name' => 'Category 1 name',
        ]);

        $category = $this->mockedClient->categories->find('123');

        $this->assertEquals('123', $category->getUuid());
        $this->assertEquals('123', $category->getExternalIdentifier());;
        $this->assertEquals('Category 1 name', $category->getName());
    }

    /** @test
     *
     * @throws PiggyRequestException
     */
    public function it_can_find_or_create_a_category(): void
    {
        $this->addExpectedResponse([
            'uuid' => '123',
            'external_identifier' => '123',
            'name' => 'Category 1 name',
        ]);

        $category = $this->mockedClient->categories->findOrCreate(
            '123',
            'Category 1 name'
        );

        $this->assertEquals('123', $category->getUuid());
        $this->assertEquals('123', $category->getExternalIdentifier());;
        $this->assertEquals('Category 1 name', $category->getName());
    }

    /** @test
     *
     * @throws PiggyRequestException
     */
    public function it_can_update_a_category(): void
    {
        $this->addExpectedResponse([
            'uuid' => '123',
            'external_identifier' => '123',
            'name' => 'Category 1 name',
        ]);

        $category = $this->mockedClient->categories->update(
            '123',
            '123',
            'Category 1 name'
        );

        $this->assertEquals('123', $category->getUuid());
        $this->assertEquals('123', $category->getExternalIdentifier());;
        $this->assertEquals('Category 1 name', $category->getName());
    }

    /** @test
     *
     * @throws PiggyRequestException
     */
    public function it_can_delete_a_category(): void
    {
        $this->addExpectedResponse(null);

        $category = $this->mockedClient->categories->delete('123');

        $this->assertNull($category);
    }

    /** @test
     *
     * @throws PiggyRequestException
     */
    public function it_can_batch_create_categories(): void
    {
        $this->addExpectedResponse([
            'status' => 'processing',
        ]);

        $response = $this->mockedClient->categories->batch([
            [
                '123',
                '123',
                'Category 1 name',
            ],
            [
                '456',
                '456',
                'Category 2 name',
            ]
        ]);

        $this->assertEquals('processing', $response->status);
    }
}