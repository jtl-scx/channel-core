<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace Core\Message;

use JTL\Nachricht\Contract\Message\AmqpTransportableMessage;
use JTL\Nachricht\Contract\Message\Message;
use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOfferIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerOfferIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerReportIdRelatedMessage;
use JTL\SCX\Lib\Channel\Core\Log\Context\ChannelOfferIdContext;
use JTL\SCX\Lib\Channel\Core\Log\Context\SellerOfferIdContext;
use JTL\SCX\Lib\Channel\Core\Log\Context\SellerReportIdContext;
use JTL\SCX\Lib\Channel\Core\Log\MessageIdContext;
use JTL\SCX\Lib\Channel\Core\Message\AbstractListener;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Message\AbstractListener
 */
class AbstractListenerTest extends TestCase
{
    public function testCanSetup(): void
    {
        $message = $this->createMock(TestMessage::class);
        $logger = $this->createMock(ScxLogger::class);
        $logger->expects(self::once())->method('reset');
        $logger->expects(self::exactly(5))->method('replaceContext')->withConsecutive(
            [self::isInstanceOf(MessageIdContext::class)],
            [self::isInstanceOf(ChannelSellerId::class)],
            [self::isInstanceOf(ChannelOfferIdContext::class)],
            [self::isInstanceOf(SellerOfferIdContext::class)],
            [self::isInstanceOf(SellerReportIdContext::class)],
        );
        $listener = new TestListener($logger);

        $listener->setup($message);
    }

    public function testCanOnError(): void
    {
        $error = $this->createStub(\Exception::class);
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

    public function getSellerOfferId(): string
    {
        return uniqid('SellerOfferId', true);
    }

    public function getSellerReportId(): string
    {
        return uniqid('SellerReportId', true);
    }
}
