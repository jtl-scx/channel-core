<?php

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Lib\Channel\Event\Seller\OrderInvoiceEvent;

/**
 * @covers \JTL\SCX\Lib\Channel\Helper\Command\EmitSellerOrderInvoiceCommand
 */
class EmitSellerOrderInvoiceCommandTest extends AbstractEmitterCommandTestCaseHelper
{
    public function testCanEmitOrderInvoiceEvent(): void
    {
        $testJsonFile = sys_get_temp_dir() . '/' . __CLASS__ . '.json';
        $json = <<<JSON
{
    "sellerId": "334334343",
    "type": "INVOICE",
    "orderId": "123-456",
    "invoiceNumber": "RN-001",
    "documentId": "e80b71a7-a2da-4670-944d-2b3ff1380d8b",
    "documentExpiresAt": "2021-07-01"
}

JSON;

        file_put_contents($testJsonFile, $json);
        $commandTest = $this->createSystemOfTest(
            EmitSellerOrderInvoiceCommand::class,
            $this->buildEmitterMock(OrderInvoiceEvent::class)
        );
        $commandTest->execute([
            'jsonFile' => $testJsonFile,
            'sellerId' => uniqid('sellerId'),
        ]);
    }
}
