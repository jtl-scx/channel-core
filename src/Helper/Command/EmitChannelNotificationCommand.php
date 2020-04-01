<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/24/20
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use InvalidArgumentException;
use JTL\Nachricht\Contract\Emitter\Emitter;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use JTL\SCX\Lib\Channel\Notification\NotificationReference;
use JTL\SCX\Lib\Channel\Notification\SendNotificationMessage;
use JTL\SCX\Lib\Channel\Notification\Severity;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EmitChannelNotificationCommand extends AbstractCommand
{
    protected static $defaultName = 'helper:emit.ChannelNotification';
    private Emitter $emitter;

    public function __construct(Emitter $emitter, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->emitter = $emitter;
    }

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Helper command to emit Channel Notification with severity INFO')
            ->addArgument('sellerId', InputArgument::REQUIRED, 'SellerId')
            ->addArgument('message', InputArgument::REQUIRED, 'Notification Message')
            ->addOption('warning', 'w', InputOption::VALUE_NONE, 'Create Notification with Severity WARNING')
            ->addOption('error', 'e', InputOption::VALUE_NONE, 'Create Notification with Severity ERROR')
            ->addOption('offerId', null, InputOption::VALUE_REQUIRED, 'Reference a OfferId')
            ->addOption('orderItemId', null, InputOption::VALUE_REQUIRED, 'Reference a OrderItemId');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $severity = $this->createSeverityFromInput($input);
        $reference = $this->createReferenceFromInput($input);
        $message = new SendNotificationMessage(
            $input->getArgument('sellerId'),
            $input->getArgument('message'),
            $severity,
            $reference
        );
        $this->emitter->emit($message);

        $log = "SendNotificationMessage with severity {$severity} emitted";
        if ($reference instanceof NotificationReference) {
            $log .= " using reference {$reference->getType()} = {$reference->getId()}";
        }
        $this->io->success($log);
    }

    /**
     * @param InputInterface $input
     * @return Severity
     */
    protected function createSeverityFromInput(InputInterface $input): Severity
    {
        $severity = Severity::INFO();
        if ($input->getOption('warning') === true) {
            $severity = Severity::WARNING();
        }
        if ($input->getOption('error') === true) {
            $severity = Severity::ERROR();
        }

        return $severity;
    }

    private function createReferenceFromInput(InputInterface $input): ?NotificationReference
    {
        $reference = null;
        $offerId = $input->getOption('offerId');
        $orderItemId = $input->getOption('orderItemId');

        if ($offerId !== null && $orderItemId !== null) {
            throw new InvalidArgumentException('When using a reference only one at a time is allowed.');
        }

        if ($offerId != null) {
            $reference = NotificationReference::offer($offerId);
        }

        if ($orderItemId !== null) {
            $reference = NotificationReference::orderItemId($orderItemId);
        }

        return $reference;
    }
}
