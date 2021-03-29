<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/13/20
 */

namespace JTL\SCX\Lib\Channel\Core\Message;

use JTL\Nachricht\Contract\Hook\AfterMessageErrorHook;
use JTL\Nachricht\Contract\Hook\BeforeMessageHook;
use JTL\Nachricht\Contract\Listener\Listener;
use JTL\Nachricht\Contract\Message\AmqpTransportableMessage;
use JTL\Nachricht\Contract\Message\Message;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\Core\Message\CancellationRequestIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOfferIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOrderIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOrderItemIdListRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\RefundIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerOfferIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerReportIdRelatedMessage;
use JTL\SCX\Lib\Channel\Core\Log\Context\CancellationRequestIdContext;
use JTL\SCX\Lib\Channel\Core\Log\Context\ChannelOfferIdContext;
use JTL\SCX\Lib\Channel\Core\Log\Context\ChannelOrderIdContext;
use JTL\SCX\Lib\Channel\Core\Log\Context\ChannelOrderItemIdListContext;
use JTL\SCX\Lib\Channel\Core\Log\Context\RefundIdContext;
use JTL\SCX\Lib\Channel\Core\Log\Context\SellerOfferIdContext;
use JTL\SCX\Lib\Channel\Core\Log\Context\SellerReportIdContext;
use JTL\SCX\Lib\Channel\Core\Log\MessageIdContext;
use Throwable;

abstract class AbstractListener implements Listener, BeforeMessageHook, AfterMessageErrorHook
{
    protected ScxLogger $logger;

    public function __construct(ScxLogger $logger)
    {
        $this->logger = $logger;
    }

    public function setup(Message $message): void
    {
        $this->logger->reset();

        if ($message instanceof AmqpTransportableMessage) {
            $this->logger->replaceContext(new MessageIdContext($message->getMessageId()));
        }
        if ($message instanceof SellerIdRelatedMessage) {
            $this->logger->replaceContext($message->getSellerId());
        }
        if ($message instanceof ChannelOfferIdRelatedMessage) {
            $this->logger->replaceContext(new ChannelOfferIdContext($message->getChannelOfferId()));
        }
        if ($message instanceof SellerOfferIdRelatedMessage) {
            $this->logger->replaceContext(new SellerOfferIdContext($message->getSellerOfferId()));
        }
        if ($message instanceof SellerReportIdRelatedMessage) {
            $this->logger->replaceContext(new SellerReportIdContext($message->getSellerReportId()));
        }
        if ($message instanceof ChannelOrderIdRelatedMessage) {
            $this->logger->replaceContext(new ChannelOrderIdContext($message->getChannelOrderId()));
        }
        if ($message instanceof ChannelOrderItemIdListRelatedMessage) {
            $this->logger->replaceContext(new ChannelOrderItemIdListContext($message->getChannelOrderItemIdList()));
        }
        if ($message instanceof CancellationRequestIdRelatedMessage) {
            $this->logger->replaceContext(new CancellationRequestIdContext($message->getCancellationRequestId()));
        }
        if ($message instanceof RefundIdRelatedMessage) {
            $this->logger->replaceContext(new RefundIdContext($message->getRefundId()));
        }
    }

    public function onError(Message $message, Throwable $throwable): void
    {
        $messageClass = get_class($message);
        $throwableClass = get_class($throwable);

        $this->logger->error("Message '{$messageClass}' failed with '{$throwableClass}' and message '{$throwable->getMessage()}");
        throw $throwable;
    }
}
