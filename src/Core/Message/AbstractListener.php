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
    }

    public function onError(Message $message, Throwable $throwable): void
    {
        $messageClass = get_class($message);
        $throwableClass = get_class($throwable);

        $this->logger->error("Message '{$messageClass}' failed with '{$throwableClass}' and message '{$throwable->getMessage()}");
        throw $throwable;
    }
}
