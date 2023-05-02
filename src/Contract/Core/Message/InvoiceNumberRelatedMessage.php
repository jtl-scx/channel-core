<?php

namespace JTL\SCX\Lib\Channel\Contract\Core\Message;

interface InvoiceNumberRelatedMessage
{
    public function getInvoiceNumber(): string;
}
