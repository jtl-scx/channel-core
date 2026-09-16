<?php

namespace JTL\SCX\Lib\Channel\Helper\Command;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use JTL\SCX\Lib\Channel\Event\Seller\OrderReturnReceived;

#[CoversClass(\JTL\SCX\Lib\Channel\Helper\Command\EmitOrderReturnReceivedCommand::class)]
class EmitOrderReturnReceivedCommandTest extends AbstractEmitterCommandTestCaseHelper
{
    #[Test]
    public function it_can_emit_return_received_event(): void
    {
        $testJsonFile = sys_get_temp_dir() . '/' . __CLASS__ . '.json';
        $json = <<<JSON
{
    "sellerId": "A_SELLE_ID",
    "orderId": "A_ORDER_ID",
    "sellerReturnId": "SELLERS_RETURN_ID",
    "channelReturnId": "CHANNELS_RETURN_ID",
    "orderItem": [
        {
            "orderItemId": "ITEM1",
            "quantity": "1.0",
            "returnReason": "NO_REASON",
            "note": "optional note",
            "condition": "ORIGINAL_PACKAGING",
            "acceptReturn": true,
            "requireReturnShipping": true
        }
    ]
}
JSON;
        file_put_contents($testJsonFile, $json);
        $commandTest = $this->createSystemOfTest(
            EmitOrderReturnReceivedCommand::class,
            $this->buildEmitterMock(OrderReturnReceived::class)
        );
        $commandTest->execute([
            'jsonFile' => $testJsonFile,
            'sellerId' => uniqid('sellerId'),
        ]);
    }
}
