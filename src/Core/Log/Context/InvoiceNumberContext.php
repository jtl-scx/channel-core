<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

class InvoiceNumberContext extends LabeledContextAware
{
    public function __construct(private readonly string $invoiceNumber)
    {
    }

    protected function getLabels(): array
    {
        return [ContextLabel::invoice];
    }

    protected function getLogContext(): array
    {
        return ['invoiceNumber' => $this->invoiceNumber];
    }

    public function createContextInstance(): callable
    {
        return $this;
    }
}