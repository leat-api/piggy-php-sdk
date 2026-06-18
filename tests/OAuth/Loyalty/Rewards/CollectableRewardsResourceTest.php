<?php

namespace Piggy\Api\Tests\OAuth\Loyalty\Rewards;

use GuzzleHttp\Exception\GuzzleException;
use Piggy\Api\Exceptions\MaintenanceModeException;
use Piggy\Api\Exceptions\PiggyRequestException;
use Piggy\Api\Models\Loyalty\Rewards\CollectableRewardRedemption;
use Piggy\Api\Tests\OAuthTestCase;

class CollectableRewardsResourceTest extends OAuthTestCase
{
    /**
     * @test
     *
     * @throws GuzzleException
     * @throws PiggyRequestException
     */
    public function it_returns_all_rewards()
    {

        $this->addExpectedResponse([
            [
                'contact' => [
                    'uuid' => '123',
                    'email' => 'nizlslzvzrt_42@hytmxil.cym',
                    'credit_balance' => [
                        'balance' => 1612,
                    ],
                ],
                'created_at' => '2022-06-30T13:29:16+00:00',
                'uuid' => '036c1eb8-c81e-4d93-9e33-2928c93fe3c1',
                'title' => 'reward test michael sdk',
                'reward' => [
                    'uuid' => 'e76e6fb2-ed67-4947-acb4-53bab93c97fa',
                    'title' => 'reward test michael sdk',
                    'description' => '',
                    'required_credits' => 5,
                    'active' => true,
                    'reward_type' => 'PHYSICAL',
                ],
                'expires_at' => '2024-06-30T13:29:16+00:00',
                'has_been_collected' => false,
            ],
            [
                'contact' => [
                    'uuid' => '456',
                    'email' => 'another_email@hytmxil.cym',
                    'credit_balance' => [
                        'balance' => 2000,
                    ],
                ],
                'created_at' => '2022-06-30T13:29:16+00:00',
                'uuid' => '059b2abc-d45f-4f9a-8e11-3956b93be7b2',
                'title' => 'second reward title',
                'reward' => [
                    'uuid' => 'b84f7fd1-e5c9-4b5a-9b25-78a6b93aa8f1',
                    'title' => 'second reward title',
                    'description' => 'This is a description',
                    'required_credits' => 10,
                    'active' => false,
                    'reward_type' => 'DIGITAL',
                ],
                'expires_at' => '2024-06-30T13:29:16+00:00',
                'has_been_collected' => false,
            ],
        ]);

        $rewards = $this->mockedClient->collectableRewards->list('123');

        $this->assertEquals('123', $rewards[0]->getContact()->getUuid());
        $this->assertEquals('nizlslzvzrt_42@hytmxil.cym', $rewards[0]->getContact()->getEmail());
        $this->assertEquals(1612, $rewards[0]->getContact()->getCreditBalance()->getBalance());
        $this->assertEquals('2022-06-30T13:29:16+00:00', $rewards[0]->getCreatedAt()->format('c'));
        $this->assertEquals('036c1eb8-c81e-4d93-9e33-2928c93fe3c1', $rewards[0]->getUuid());
        $this->assertEquals('reward test michael sdk', $rewards[0]->getTitle());
        $this->assertEquals('e76e6fb2-ed67-4947-acb4-53bab93c97fa', $rewards[0]->getReward()->getUuid());
        $this->assertEquals('reward test michael sdk', $rewards[0]->getReward()->getTitle());
        $this->assertEquals('', $rewards[0]->getReward()->getDescription());
        $this->assertEquals(5, $rewards[0]->getReward()->getRequiredCredits());
        $this->assertTrue($rewards[0]->getReward()->isActive());
        $this->assertEquals('PHYSICAL', $rewards[0]->getReward()->getRewardType());
        $this->assertEquals('2024-06-30T13:29:16+00:00', $rewards[0]->getExpiresAt()->format('c'));
        $this->assertFalse($rewards[0]->hasBeenCollected());

        $this->assertEquals('456', $rewards[1]->getContact()->getUuid());
        $this->assertEquals('another_email@hytmxil.cym', $rewards[1]->getContact()->getEmail());
        $this->assertEquals(2000, $rewards[1]->getContact()->getCreditBalance()->getBalance());
        $this->assertEquals('2022-06-30T13:29:16+00:00', $rewards[1]->getCreatedAt()->format('c'));
        $this->assertEquals('059b2abc-d45f-4f9a-8e11-3956b93be7b2', $rewards[1]->getUuid());
        $this->assertEquals('second reward title', $rewards[1]->getTitle());
        $this->assertEquals('b84f7fd1-e5c9-4b5a-9b25-78a6b93aa8f1', $rewards[1]->getReward()->getUuid());
        $this->assertEquals('second reward title', $rewards[1]->getReward()->getTitle());
        $this->assertEquals('This is a description', $rewards[1]->getReward()->getDescription());
        $this->assertEquals(10, $rewards[1]->getReward()->getRequiredCredits());
        $this->assertFalse($rewards[1]->getReward()->isActive());
        $this->assertEquals('DIGITAL', $rewards[1]->getReward()->getRewardType());
        $this->assertEquals('2024-06-30T13:29:16+00:00', $rewards[1]->getExpiresAt()->format('c'));
        $this->assertFalse($rewards[1]->hasBeenCollected());
    }

    /**
     * @test
     *
     * @throws GuzzleException
     * @throws PiggyRequestException
     * @throws MaintenanceModeException
     */
    public function it_collects_a_reward_and_returns_a_redemption()
    {
        $this->addExpectedResponse([
            'uuid' => '036c1eb8-c81e-4d93-9e33-2928c93fe3c1',
            'status' => 'COLLECTED',
        ]);

        $redemption = $this->mockedClient->collectableRewards->collect('f549824e-8c56-4a0e-b3d7-5824d0c57757');

        $this->assertInstanceOf(CollectableRewardRedemption::class, $redemption);
        $this->assertEquals('036c1eb8-c81e-4d93-9e33-2928c93fe3c1', $redemption->getUuid());
        $this->assertEquals('COLLECTED', $redemption->getStatus());
    }
}
