<?php

namespace Tests\unit\OfferBundle\AMQP;

use Doctrine\ORM\EntityManager;
use MarketingBundle\Service\AMQP\Consumer\ScoringConsumer;
use Mullenlowe\CommonBundle\Test\PrivateUnit;
use PhpAmqpLib\Message\AMQPMessage;

class ScoringConsumerTest extends PrivateUnit
{

    /** @var EntityManager */
    private $_em;

    /** @var ScoringConsumer */
    private $_scoring;

    protected function _before()
    {
        $this->_em = $this->createMock(EntityManager::class);
        $this->_scoring = new ScoringConsumer($this->_em);
    }

    /**
     * @dataProvider getInvalidBodies
     */
    public function testGetMessageBodyInvalidDataFormat($body, $error)
    {
        $msg = new AMQPMessage($body);
        try {
            $this->getResultFromMethod($this->_scoring, 'getMessageBody', [$msg]);
        } catch (\Exception $e) {
            $this->assertEquals($error, $e->getMessage());
        }
    }

    public function getInvalidBodies()
    {
        return [
            ['lorem', 'Invalid json message'],
            ['{"data": "lorem"}', 'Missing or empty "context" field'],
            ['{"context": "lorem"}', 'Missing or empty "data" field'],
            ['{"context": "lorem", "data": "ipsum"}', '"data" field must be typed as array'],
            ['{"context": "lorem", "data": ["ipsum"]}', '"data" array must contains interest, seriousness, contactType, myaudiUserId'],
        ];
    }
}