<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/06/04
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Lib\Channel\Event\Seller\OrderConfirmedEvent;

/**
 * @covers \JTL\SCX\Lib\Channel\Helper\Command\EmitOrderAcceptCommand
 */
class EmitOrderAcceptCommandTest extends AbstractEmitterCommandTestCaseHelper
{
    public function testCanEmitOrderAcceptEvent(): void
    {
        $testJsonFile = sys_get_temp_dir() . '/' . __CLASS__ . '.json';
        $json = <<<JSON
{
    "sellerId": "334334343",
    "orderId": "4711",
    "orderAccepted": true
}
JSON;

        file_put_contents($testJsonFile, $json);

        $commandTest = $this->createSystemOfTest(
            EmitOrderAcceptCommand::class,
            $this->buildEmitterMock(OrderConfirmedEvent::class)
        );
        $commandTest->execute([
            'jsonFile' => $testJsonFile,
            'sellerId' => uniqid('sellerId'),
        ]);
    }
}
