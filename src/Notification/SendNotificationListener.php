<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/23/20
 */

namespace JTL\SCX\Lib\Channel\Notification;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Channel\Api\Notification\NotificationApi;
use JTL\SCX\Client\Channel\Api\Notification\Request\NotificationRequest;
use JTL\SCX\Client\Channel\Model\ChannelNotificationReference;
use JTL\SCX\Client\Channel\Model\Notification;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Message\AbstractListener;

class SendNotificationListener extends AbstractListener
{
    private NotificationApi $notificationApi;

    public function __construct(NotificationApi $notificationApi, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->notificationApi = $notificationApi;
    }

    /**
     * @param SendNotificationMessage $message
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function sendNotification(SendNotificationMessage $message)
    {
        $model = new Notification();
        $model->setSellerId($message->getSellerId());
        $model->setMessage($message->getMessage());
        $model->setSeverity((string)$message->getSeverity());

        if ($message->getReference() instanceof NotificationReference) {
            $reference = new ChannelNotificationReference();
            $reference->setId($message->getReference()->getId());
            $reference->setType($message->getReference()->getType());
            $model->setReference($reference);
        }

        $this->logger->debug("RequestBody: '" . (string)$model . "'");
        $this->notificationApi->send(new NotificationRequest($model));
        $this->logger->info("ChannelNotification successful send");
    }
}
