<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 7/30/21
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use DateTimeImmutable;
use JTL\Nachricht\Contract\Serializer\MessageSerializer;
use JTL\Nachricht\Contract\Transport\Amqp\AmqpQueueLister;
use JTL\Nachricht\Transport\Amqp\AmqpTransport;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;
use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class DeadLetterRetryCommand
 *
 * @package JTL\SCX\Lib\Channel\Core\Command
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Command\DeadLetterRetryCommand
 */
class DeadLetterRetryCommandTest extends TestCase
{
    /**
     * @var AmqpTransport|MockObject
     */
    private $transport;

    /**
     * @var AmqpQueueLister|MockObject
     */
    private $queueLister;

    /**
     * @var MessageSerializer|MockObject
     */
    private $messageSerializer;

    /**
     * @var ScxLogger|MockObject
     */
    private $logger;

    public function setUp(): void
    {
        $this->transport = $this->createMock(AmqpTransport::class);
        $this->queueLister = $this->createMock(AmqpQueueLister::class);
        $this->messageSerializer = $this->createMock(MessageSerializer::class);
        $this->logger = $this->createMock(ScxLogger::class);
    }

    public function testListAndAskQueuesWithoutOptions(): void
    {
        $queueName = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);
        $routingKey = uniqid('routingKey', true);
        $deliveryTag = uniqid('deliveryTag', true);
        $isRedelivered = uniqid('isRedelivered', true);
        $exchange = uniqid('exchange', true);

        $message = $this->createMock(AMQPMessage::class);
        $event = $this->createMock(AbstractEvent::class);

        $this->transport->expects(self::once())
            ->method('connect');

        $this->queueLister->expects(self::once())
            ->method('listQueues')
            ->with(AmqpTransport::DEAD_LETTER_QUEUE_PREFIX)
            ->willReturn([$queueName]);

        $this->transport->expects(self::once())
            ->method('countMessagesInQueue')
            ->with($queueName)
            ->willReturn(2);

        $this->transport->expects(self::exactly(2))
            ->method('getMessageFromQueue')
            ->with($queueName, false)
            ->willReturnOnConsecutiveCalls($message, null);

        $message->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $this->messageSerializer->expects(self::once())
            ->method('deserialize')
            ->with('')
            ->willReturn($event);

        $message->expects(self::once())
            ->method('getRoutingKey')
            ->willReturn($routingKey);

        $message->expects(self::once())
            ->method('getDeliveryTag')
            ->willReturn($deliveryTag);

        $message->expects(self::once())
            ->method('isRedelivered')
            ->willReturn($isRedelivered);

        $message->expects(self::once())
            ->method('getExchange')
            ->willReturn($exchange);

        $message->expects(self::once())
            ->method('setDeliveryInfo')
            ->with($deliveryTag, $isRedelivered, $exchange, substr($routingKey, 4));

        $this->transport->expects(self::once())
            ->method('ack')
            ->with($message);

        $this->transport->expects(self::once())
            ->method('directPublish')
            ->with($message);

        $command = new DeadLetterRetryCommand(
            $this->transport,
            $this->queueLister,
            $this->messageSerializer,
            $this->logger
        );
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['0']);
        $commandTester->execute([]);
    }

    public function testCanRetryMessagesWithDefaultActionDelete(): void
    {
        $queueName = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);

        $message = $this->createMock(AMQPMessage::class);
        $event = $this->createMock(AbstractEvent::class);

        $this->transport->expects(self::once())
            ->method('connect');

        $this->queueLister->expects(self::once())
            ->method('listQueues')
            ->with(AmqpTransport::DEAD_LETTER_QUEUE_PREFIX)
            ->willReturn([$queueName]);

        $this->transport->expects(self::once())
            ->method('countMessagesInQueue')
            ->with($queueName)
            ->willReturn(1);

        $this->transport->expects(self::once())
            ->method('getMessageFromQueue')
            ->with($queueName, false)
            ->willReturn($message);

        $message->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $this->messageSerializer->expects(self::once())
            ->method('deserialize')
            ->with('')
            ->willReturn($event);

        $message->expects(self::never())
            ->method('getRoutingKey');

        $this->transport->expects(self::once())
            ->method('ack')
            ->with($message);

        $this->transport->expects(self::never())
            ->method('directPublish');

        $command = new DeadLetterRetryCommand(
            $this->transport,
            $this->queueLister,
            $this->messageSerializer,
            $this->logger
        );
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['0']);
        $commandTester->execute(
            [
                '--default-action' => 'delete',
            ]
        );
    }

    public function testCanRetryMessagesWithDefaultActionDeleteAndMessageType(): void
    {
        $queueName1 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);
        $queueName2 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);
        $queueName3 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);
        $queueName4 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true) . 'specifictestqueue';

        $message = $this->createMock(AMQPMessage::class);
        $event = $this->createMock(AbstractEvent::class);

        $this->transport->expects(self::once())
            ->method('connect');

        $this->queueLister->expects(self::once())
            ->method('listQueues')
            ->with(AmqpTransport::DEAD_LETTER_QUEUE_PREFIX)
            ->willReturn([$queueName1, $queueName2, $queueName3, $queueName4]);

        $this->transport->expects(self::once())
            ->method('countMessagesInQueue')
            ->with($queueName4)
            ->willReturn(1);

        $this->transport->expects(self::once())
            ->method('getMessageFromQueue')
            ->with($queueName4, false)
            ->willReturn($message);

        $message->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $this->messageSerializer->expects(self::once())
            ->method('deserialize')
            ->with('')
            ->willReturn($event);

        $message->expects(self::never())
            ->method('getRoutingKey');

        $this->transport->expects(self::once())
            ->method('ack')
            ->with($message);

        $this->transport->expects(self::never())
            ->method('directPublish');

        $command = new DeadLetterRetryCommand(
            $this->transport,
            $this->queueLister,
            $this->messageSerializer,
            $this->logger
        );
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                'type' => 'testqueue',
                '--default-action' => 'delete',
            ]
        );
    }

    public function testCanRetryMessagesWithDefaultActionDeleteAndMessageTypeWhereMultipleQueuesAreFound(): void
    {
        $queueName1 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);
        $queueName2 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);
        $queueName3 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true) . 'anothertestqueue';
        $queueName4 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true) . 'specifictestqueue';

        $message = $this->createMock(AMQPMessage::class);
        $event = $this->createMock(AbstractEvent::class);

        $this->transport->expects(self::once())
            ->method('connect');

        $this->queueLister->expects(self::once())
            ->method('listQueues')
            ->with(AmqpTransport::DEAD_LETTER_QUEUE_PREFIX)
            ->willReturn([$queueName1, $queueName2, $queueName3, $queueName4]);

        $this->transport->expects(self::once())
            ->method('countMessagesInQueue')
            ->with($queueName4)
            ->willReturn(1);

        $this->transport->expects(self::once())
            ->method('getMessageFromQueue')
            ->with($queueName4, false)
            ->willReturn($message);

        $message->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $this->messageSerializer->expects(self::once())
            ->method('deserialize')
            ->with('')
            ->willReturn($event);

        $message->expects(self::never())
            ->method('getRoutingKey');

        $this->transport->expects(self::once())
            ->method('ack')
            ->with($message);

        $this->transport->expects(self::never())
            ->method('directPublish');

        $command = new DeadLetterRetryCommand(
            $this->transport,
            $this->queueLister,
            $this->messageSerializer,
            $this->logger
        );
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['1']);
        $commandTester->execute(
            [
                'type' => 'testqueue',
                '--default-action' => 'delete',
            ]
        );
    }

    public function testCanRetryMessagesWithDefaultActionDeleteAndMessageTypeWhereNoQueuesAreFound(): void
    {
        $queueName1 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);
        $queueName2 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);
        $queueName3 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true) . 'anothertestqueue';
        $queueName4 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true) . 'specifictestqueue';

        $this->transport->expects(self::once())
            ->method('connect');

        $this->queueLister->expects(self::once())
            ->method('listQueues')
            ->with(AmqpTransport::DEAD_LETTER_QUEUE_PREFIX)
            ->willReturn([$queueName1, $queueName2, $queueName3, $queueName4]);

        $command = new DeadLetterRetryCommand(
            $this->transport,
            $this->queueLister,
            $this->messageSerializer,
            $this->logger
        );
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['1']);
        $commandTester->execute(
            [
                'type' => 'imsurethisqueuedoesnotexist',
                '--default-action' => 'delete',
            ]
        );

        self::assertStringContainsString('Could not find any queues', $commandTester->getDisplay());
    }

    public function testCanRetryMessagesWithDefaultActionDeleteWhichAreOlderThanSuppliedDate(): void
    {
        $queueName = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);

        $message1 = $this->createMock(AMQPMessage::class);
        $message2 = $this->createMock(AMQPMessage::class);
        $message3 = $this->createMock(AMQPMessage::class);
        $event1 = $this->createMock(AbstractEvent::class);
        $event2 = $this->createMock(AbstractEvent::class);
        $event3 = $this->createMock(AbstractEvent::class);

        $this->transport->expects(self::once())
            ->method('connect');

        $this->queueLister->expects(self::once())
            ->method('listQueues')
            ->with(AmqpTransport::DEAD_LETTER_QUEUE_PREFIX)
            ->willReturn([$queueName]);

        $this->transport->expects(self::once())
            ->method('countMessagesInQueue')
            ->with($queueName)
            ->willReturn(3);

        $this->transport->expects(self::exactly(3))
            ->method('getMessageFromQueue')
            ->with($queueName, false)
            ->willReturnOnConsecutiveCalls($message1, $message2, $message3);

        $message1->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $message2->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $message3->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $this->messageSerializer->expects(self::exactly(3))
            ->method('deserialize')
            ->willReturnOnConsecutiveCalls($event1, $event2, $event3);

        $event1->expects(self::once())
            ->method('getCreatedAt')
            ->willReturn(new DateTimeImmutable('2020-01-01'));

        $event2->expects(self::once())
            ->method('getCreatedAt')
            ->willReturn(new DateTimeImmutable('2020-01-01'));

        $event3->expects(self::once())
            ->method('getCreatedAt')
            ->willReturn(new DateTimeImmutable('2021-07-30T00:00:00Z'));

        $this->transport->expects(self::exactly(2))
            ->method('ack')
            ->withConsecutive([$message1], [$message2]);

        $command = new DeadLetterRetryCommand(
            $this->transport,
            $this->queueLister,
            $this->messageSerializer,
            $this->logger
        );
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['0']);
        $commandTester->execute(
            [
                '--default-action' => 'delete',
                '--older-than' => '2021-07-10T00:00:00Z',
            ]
        );
    }

    public function testCanRetryMessagesWithDefaultActionDeleteAndLastErrorFilter(): void
    {
        $queueName = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);

        $message1 = $this->createMock(AMQPMessage::class);
        $message2 = $this->createMock(AMQPMessage::class);
        $message3 = $this->createMock(AMQPMessage::class);
        $event1 = $this->createMock(AbstractEvent::class);
        $event2 = $this->createMock(AbstractEvent::class);
        $event3 = $this->createMock(AbstractEvent::class);

        $this->transport->expects(self::once())
            ->method('connect');

        $this->queueLister->expects(self::once())
            ->method('listQueues')
            ->with(AmqpTransport::DEAD_LETTER_QUEUE_PREFIX)
            ->willReturn([$queueName]);

        $this->transport->expects(self::once())
            ->method('countMessagesInQueue')
            ->with($queueName)
            ->willReturn(3);

        $this->transport->expects(self::exactly(3))
            ->method('getMessageFromQueue')
            ->with($queueName, false)
            ->willReturnOnConsecutiveCalls($message1, $message2, $message3);

        $message1->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $message2->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $message3->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $this->messageSerializer->expects(self::exactly(3))
            ->method('deserialize')
            ->willReturnOnConsecutiveCalls($event1, $event2, $event3);

        $event1->expects(self::once())
            ->method('getLastErrorMessage')
            ->willReturn('This event failed horribly');

        $event2->expects(self::once())
            ->method('getLastErrorMessage')
            ->willReturn('Could not process event "SellerOfferEventNew"');

        $event3->expects(self::once())
            ->method('getLastErrorMessage')
            ->willReturn('Something happened');

        $this->transport->expects(self::once())
            ->method('ack')
            ->with($message2);

        $command = new DeadLetterRetryCommand(
            $this->transport,
            $this->queueLister,
            $this->messageSerializer,
            $this->logger
        );
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['0']);
        $commandTester->execute(
            [
                '--default-action' => 'delete',
                '--filter-by-lasterror' => 'could not process event offerevent',
            ]
        );
    }

    public function testCanRetryMessagesWithDefaultActionDeleteAndLastErrorFilter2(): void
    {
        $queueName = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);

        $message1 = $this->createMock(AMQPMessage::class);
        $message2 = $this->createMock(AMQPMessage::class);
        $message3 = $this->createMock(AMQPMessage::class);
        $event1 = $this->createMock(AbstractEvent::class);
        $event2 = $this->createMock(AbstractEvent::class);
        $event3 = $this->createMock(AbstractEvent::class);

        $this->transport->expects(self::once())
            ->method('connect');

        $this->queueLister->expects(self::once())
            ->method('listQueues')
            ->with(AmqpTransport::DEAD_LETTER_QUEUE_PREFIX)
            ->willReturn([$queueName]);

        $this->transport->expects(self::once())
            ->method('countMessagesInQueue')
            ->with($queueName)
            ->willReturn(3);

        $this->transport->expects(self::exactly(3))
            ->method('getMessageFromQueue')
            ->with($queueName, false)
            ->willReturnOnConsecutiveCalls($message1, $message2, $message3);

        $message1->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $message2->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $message3->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $this->messageSerializer->expects(self::exactly(3))
            ->method('deserialize')
            ->willReturnOnConsecutiveCalls($event1, $event2, $event3);

        $event1->expects(self::once())
            ->method('getLastErrorMessage')
            ->willReturn('This event failed horribly');

        $event2->expects(self::once())
            ->method('getLastErrorMessage')
            ->willReturn('Could not process event "SellerOfferEventNew" because this string is too padded already');

        $event3->expects(self::once())
            ->method('getLastErrorMessage')
            ->willReturn('Something happened');

        $this->transport->expects(self::once())
            ->method('ack')
            ->with($message2);

        $command = new DeadLetterRetryCommand(
            $this->transport,
            $this->queueLister,
            $this->messageSerializer,
            $this->logger
        );
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['0']);
        $commandTester->execute(
            [
                '--default-action' => 'delete',
                '--filter-by-lasterror' => 'selleroffereventnew',
            ]
        );
    }

    public function testCanRetryMessagesWithDefaultActionYesAndResetReceives(): void
    {
        $queueName = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);
        $routingKey = uniqid('routingKey', true);
        $deliveryTag = uniqid('deliveryTag', true);
        $isRedelivered = uniqid('isRedelivered', true);
        $exchange = uniqid('exchange', true);

        $message = $this->createMock(AMQPMessage::class);
        $event = $this->createMock(AbstractEvent::class);

        $this->transport->expects(self::once())
            ->method('connect');

        $this->queueLister->expects(self::once())
            ->method('listQueues')
            ->with(AmqpTransport::DEAD_LETTER_QUEUE_PREFIX)
            ->willReturn([$queueName]);

        $this->transport->expects(self::once())
            ->method('countMessagesInQueue')
            ->with($queueName)
            ->willReturn(1);

        $this->transport->expects(self::once())
            ->method('getMessageFromQueue')
            ->with($queueName, false)
            ->willReturn($message);

        $message->expects(self::exactly(2))
            ->method('getBody')
            ->willReturn('');

        $this->messageSerializer->expects(self::exactly(2))
            ->method('deserialize')
            ->willReturn($event);

        $message->expects(self::once())
            ->method('getRoutingKey')
            ->willReturn($routingKey);

        $message->expects(self::once())
            ->method('getDeliveryTag')
            ->willReturn($deliveryTag);

        $message->expects(self::once())
            ->method('isRedelivered')
            ->willReturn($isRedelivered);

        $message->expects(self::once())
            ->method('getExchange')
            ->willReturn($exchange);

        $message->expects(self::once())
            ->method('setDeliveryInfo')
            ->with($deliveryTag, $isRedelivered, $exchange, substr($routingKey, 4));

        $event->expects(self::once())
            ->method('setReceiveCount')
            ->with(0);

        $this->messageSerializer->expects(self::once())
            ->method('serialize')
            ->with($event)
            ->willReturn('');

        $message->expects(self::once())
            ->method('setBody')
            ->with('');

        $this->transport->expects(self::once())
            ->method('ack')
            ->with($message);

        $this->transport->expects(self::once())
            ->method('directPublish')
            ->with($message);

        $command = new DeadLetterRetryCommand(
            $this->transport,
            $this->queueLister,
            $this->messageSerializer,
            $this->logger
        );
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['0']);
        $commandTester->execute(
            [
                '--default-action' => 'yes',
                '--reset-receives' => true,
            ]
        );
    }

    public function testCanRetryMessagesAndShowEmptyQueues(): void
    {
        $queueName1 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);
        $queueName2 = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);
        $routingKey = uniqid('routingKey', true);
        $deliveryTag = uniqid('deliveryTag', true);
        $isRedelivered = uniqid('isRedelivered', true);
        $exchange = uniqid('exchange', true);

        $message = $this->createMock(AMQPMessage::class);
        $event = $this->createMock(AbstractEvent::class);

        $this->transport->expects(self::once())
            ->method('connect');

        $this->queueLister->expects(self::once())
            ->method('listQueues')
            ->with(AmqpTransport::DEAD_LETTER_QUEUE_PREFIX)
            ->willReturn([$queueName1, $queueName2]);

        $this->transport->expects(self::exactly(2))
            ->method('countMessagesInQueue')
            ->withConsecutive([$queueName1], [$queueName2])
            ->willReturn(1);

        $this->transport->expects(self::once())
            ->method('getMessageFromQueue')
            ->with($queueName1, false)
            ->willReturn($message);

        $message->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $this->messageSerializer->expects(self::once())
            ->method('deserialize')
            ->willReturn($event);

        $message->expects(self::once())
            ->method('getRoutingKey')
            ->willReturn($routingKey);

        $message->expects(self::once())
            ->method('getDeliveryTag')
            ->willReturn($deliveryTag);

        $message->expects(self::once())
            ->method('isRedelivered')
            ->willReturn($isRedelivered);

        $message->expects(self::once())
            ->method('getExchange')
            ->willReturn($exchange);

        $message->expects(self::once())
            ->method('setDeliveryInfo')
            ->with($deliveryTag, $isRedelivered, $exchange, substr($routingKey, 4));

        $this->transport->expects(self::once())
            ->method('ack')
            ->with($message);

        $this->transport->expects(self::once())
            ->method('directPublish')
            ->with($message);

        $command = new DeadLetterRetryCommand(
            $this->transport,
            $this->queueLister,
            $this->messageSerializer,
            $this->logger
        );
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['0']);
        $commandTester->execute(
            [
                '--show-empty' => true,
            ]
        );
    }

    public function testCanSetOptionDefaultValues(): void
    {
        $queueName = AmqpTransport::DEAD_LETTER_QUEUE_PREFIX . uniqid('queueName', true);
        $routingKey = uniqid('routingKey', true);
        $deliveryTag = uniqid('deliveryTag', true);
        $isRedelivered = uniqid('isRedelivered', true);
        $exchange = uniqid('exchange', true);

        $message = $this->createMock(AMQPMessage::class);
        $event = $this->createMock(AbstractEvent::class);

        $this->transport->expects(self::once())
            ->method('connect');

        $this->queueLister->expects(self::once())
            ->method('listQueues')
            ->with(AmqpTransport::DEAD_LETTER_QUEUE_PREFIX)
            ->willReturn([$queueName]);

        $this->transport->expects(self::once())
            ->method('countMessagesInQueue')
            ->with($queueName)
            ->willReturn(1);

        $this->transport->expects(self::once())
            ->method('getMessageFromQueue')
            ->with($queueName, false)
            ->willReturn($message);

        $message->expects(self::once())
            ->method('getBody')
            ->willReturn('');

        $this->messageSerializer->expects(self::once())
            ->method('deserialize')
            ->willReturn($event);

        $message->expects(self::once())
            ->method('getRoutingKey')
            ->willReturn($routingKey);

        $message->expects(self::once())
            ->method('getDeliveryTag')
            ->willReturn($deliveryTag);

        $message->expects(self::once())
            ->method('isRedelivered')
            ->willReturn($isRedelivered);

        $message->expects(self::once())
            ->method('getExchange')
            ->willReturn($exchange);

        $message->expects(self::once())
            ->method('setDeliveryInfo')
            ->with($deliveryTag, $isRedelivered, $exchange, substr($routingKey, 4));

        $this->transport->expects(self::once())
            ->method('ack')
            ->with($message);

        $this->transport->expects(self::once())
            ->method('directPublish')
            ->with($message);

        $command = new DeadLetterRetryCommand(
            $this->transport,
            $this->queueLister,
            $this->messageSerializer,
            $this->logger
        );
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['0']);
        $commandTester->execute(
            [
                '--older-than' => true,
                '--filter-by-lasterror' => true,
                '--reset-receives' => 'asdf',
                '--show-empty' => 'asdf',
            ]
        );
    }
}
