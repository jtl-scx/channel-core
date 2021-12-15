<?php declare(strict_types=1);


namespace JTL\SCX\Lib\Channel\Core\Metrics;

use JTL\GoPrometrics\Client\Label;
use JTL\GoPrometrics\Client\LabelList;
use JTL\Nachricht\Contract\Message\Message;

class MessageCounter
{
    private Counter $counter;

    public function __construct(Counter $counter)
    {
        $this->counter = $counter;
    }

    public function countMessage(Message $message): void
    {
        $labelList = new LabelList();
        $labelList->add(new Label('message', get_class($message)));

        $this->counter->countKey('messages_total', $labelList);
    }
}
