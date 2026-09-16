<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Message;

use PHPUnit\Framework\Attributes\CoversClass;
use Exception;
use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOfferIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerOfferIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerReportIdRelatedMessage;
use JTL\SCX\Lib\Channel\Core\Log\Context\ChannelOfferIdContext;
use JTL\SCX\Lib\Channel\Core\Log\Context\MessageFQNContext;
use JTL\SCX\Lib\Channel\Core\Log\Context\SellerOfferIdContext;
use JTL\SCX\Lib\Channel\Core\Log\Context\SellerReportIdContext;
use JTL\SCX\Lib\Channel\Core\Log\MessageIdContext;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Core\Message\AbstractListener::class)]
class AbstractListenerTest extends TestCase
{
    public function testCanSetup(): void
    {
        $message = $this->createStub(TestMessage::class);
        $logger = $this->createMock(ScxLogger::class);
        $logger->expects(self::once())->method('reset');
        $matcher = self::exactly(6);
        $logger->expects($matcher)->method('replaceContext')->willReturnCallback(function (...$parameters) use ($matcher) {
            if ($matcher->numberOfInvocations() === 1) {
                $this->assertInstanceOf(MessageFQNContext::class, $parameters[0]);
            }
            if ($matcher->numberOfInvocations() === 2) {
                $this->assertInstanceOf(MessageIdContext::class, $parameters[0]);
            }
            if ($matcher->numberOfInvocations() === 3) {
                $this->assertInstanceOf(ChannelSellerId::class, $parameters[0]);
            }
            if ($matcher->numberOfInvocations() === 4) {
                $this->assertInstanceOf(ChannelOfferIdContext::class, $parameters[0]);
            }
            if ($matcher->numberOfInvocations() === 5) {
                $this->assertInstanceOf(SellerOfferIdContext::class, $parameters[0]);
            }
            if ($matcher->numberOfInvocations() === 6) {
                $this->assertInstanceOf(SellerReportIdContext::class, $parameters[0]);
            }
        });
        $listener = new TestListener($logger);

        $listener->setup($message);
    }

    public function testCanOnError(): void
    {
        $error = $this->createStub(Exception::class);
        $message = $this->createStub(TestMessage::class);
        $logger = $this->createMock(ScxLogger::class);
        $logger->expects(self::once())->method('error')->with(self::callback(
            function (string $errorMessage) use ($error, $message) {
                if (strpos($errorMessage, get_class($error)) !== false && strpos($errorMessage, get_class($message))) {
                    return true;
                }

                return false;
            }
        ));
        $listener = new TestListener($logger);

        $this->expectException(get_class($error));
        $listener->onError($message, $error);
    }
}

class TestListener extends AbstractListener
{
}

class TestMessage extends AbstractAmqpTransportableMessage implements SellerIdRelatedMessage, ChannelOfferIdRelatedMessage, SellerOfferIdRelatedMessage, SellerReportIdRelatedMessage
{
    public function getChannelOfferId(): string
    {
        return uniqid('ChannelOfferId', true);
    }

    public function getSellerId(): ChannelSellerId
    {
        return new ChannelSellerId(uniqid('SellerId', true));
    }

    public function getSellerOfferId(): int
    {
        return random_int(1, 10000);
    }

    public function getSellerReportId(): string
    {
        return uniqid('SellerReportId', true);
    }
}
