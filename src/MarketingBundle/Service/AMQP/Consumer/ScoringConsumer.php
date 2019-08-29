<?php

namespace MarketingBundle\Service\AMQP\Consumer;


use Doctrine\ORM\EntityManagerInterface;
use MarketingBundle\Entity\Score;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class ScoringConsumer implements ConsumerInterface
{

    /** @var EntityManagerInterface */
    protected $em;

    /**
     * ScoringConsumer constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param AMQPMessage $msg The message
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        try {
            $body = $this->getMessageBody($msg);
            $data = $body['data'];

            $interest = floatval($data['interest']);
            $seriousness = floatval($data['seriousness']);
            $contactType = $data['contactType'];
            $myaudiUserId = intval($data['myaudiUserId']);

            $scores = $this
                ->em
                ->getRepository(Score::class)
                ->findBy(['myaudiUserId' => $myaudiUserId], ['createdAt' => 'DESC']);

            // If the last MyaudiUser's score is the same on of the current score, no insert will be done.
            if (count($scores) > 0 && ($lastScore = $scores[0]) && $contactType === $lastScore->getContactType() &&
                $seriousness === $lastScore->getSeriousness() && $interest === $lastScore->getInterestAverage()) {
                    /** @var Score $score */
                    $score = $lastScore;
                    $score->setUpdatedAt(new \DateTime());
            } else {
                $score = new Score();
                $score->setSeriousness($seriousness)
                    ->setContactType($contactType)
                    ->setInterestAverage($interest)
                    ->setMyaudiUserId($myaudiUserId);
            }

            $this->em->persist($score);
            $this->em->flush();

            return ConsumerInterface::MSG_ACK;
        } catch (\Exception $ex) {
            return ConsumerInterface::MSG_REJECT;
        }
    }

    /**
     * Validate the message body, and throw en exception is not valid
     *
     * @param AMQPMessage $msg
     * @return array the decoded body from json
     * @throws \InvalidArgumentException
     */
    private function getMessageBody(AMQPMessage $msg)
    {
        $body = json_decode($msg->getBody(), true);
        if (null === $body) {
            throw new \InvalidArgumentException('Invalid json message');
        }

        if (empty($body['context'])) {
            throw new \InvalidArgumentException('Missing or empty "context" field');
        }

        if (empty($body['data'])) {
            throw new \InvalidArgumentException('Missing or empty "data" field');
        }

        if (!is_array($body['data'])) {
            throw new \InvalidArgumentException('"data" field must be typed as array');
        }

        $mandatoryKeys = ['interest', 'seriousness', 'contactType', 'myaudiUserId'];

        if (count(array_intersect(array_keys($body['data']), $mandatoryKeys)) < count($mandatoryKeys)) {
            throw new \InvalidArgumentException(
                sprintf('"data" array must contains %s', implode(', ', $mandatoryKeys))
            );
        }

        return $body;
    }
}