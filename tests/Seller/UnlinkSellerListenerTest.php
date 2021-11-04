<?php

namespace JTL\SCX\Lib\Channel\Seller;

use JTL\SCX\Client\Channel\Api\Seller\Request\UnlinkSellerRequest;
use JTL\SCX\Client\Channel\Api\Seller\Response\UnlinkSellerResponse;
use JTL\SCX\Client\Channel\Api\Seller\SellerApi;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use PHPUnit\Framework\TestCase;

/**
 * @covers  \JTL\SCX\Lib\Channel\Seller\UnlinkSellerListener
 */
class UnlinkSellerListenerTest extends TestCase
{
    public function testCanUnlink(): void
    {
        $sellerId = new ChannelSellerId(uniqid('sellerId', true));
        $reason = uniqid('reason', true);
        $message = new UnlinkSellerMessage($sellerId, $reason);

        $unlinkSellerResponseMock = $this->createMock(UnlinkSellerResponse::class);
        $unlinkSellerResponseMock->expects(self::once())->method('isSuccessful')->willReturn(true);
        $sellerApiMock = $this->createMock(SellerApi::class);
        $sellerApiMock->expects(self::once())->method('unlink')
            ->with(self::callback(function (UnlinkSellerRequest $request) use ($sellerId, $reason) {
                $expected = [
                    'sellerId' => (string)$sellerId,
                    'reason' => $reason,
                ];
                return $request->getParams() === $expected;
            }))->willReturn($unlinkSellerResponseMock);
        $sut = new UnlinkSellerListener($sellerApiMock, $this->createStub(ScxLogger::class));
        $sut->unlink($message);
    }

    public function testUnlinkCanFail(): void
    {
        $sellerId = new ChannelSellerId(uniqid('sellerId', true));
        $reason = uniqid('reason', true);
        $message = new UnlinkSellerMessage($sellerId, $reason);

        $unlinkSellerResponseMock = $this->createMock(UnlinkSellerResponse::class);
        $unlinkSellerResponseMock->expects(self::once())->method('isSuccessful')->willReturn(false);
        $sellerApiMock = $this->createMock(SellerApi::class);
        $sellerApiMock->expects(self::once())->method('unlink')
            ->with(self::callback(function (UnlinkSellerRequest $request) use ($sellerId, $reason) {
                $expected = [
                    'sellerId' => (string)$sellerId,
                    'reason' => $reason,
                ];
                return $request->getParams() === $expected;
            }))->willReturn($unlinkSellerResponseMock);
        $sut = new UnlinkSellerListener($sellerApiMock, $this->createStub(ScxLogger::class));

        $this->expectException(\RuntimeException::class);
        $sut->unlink($message);
    }
}
