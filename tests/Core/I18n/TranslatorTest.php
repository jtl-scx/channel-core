<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 10/28/20
 */

namespace JTL\SCX\Lib\Channel\Core\I18n;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

#[CoversClass(\JTL\SCX\Lib\Channel\Core\I18n\Translator::class)]
class TranslatorTest extends TestCase
{
    public function testItCanTranslateString()
    {
        $translatorMock = $this->createMock(TranslatorInterface::class);
        $translatorMock->expects($this->once())->method('trans')
            ->with('Bier', [], $this->anything(), 'en_EN')
            ->willReturn('Beer');

        $sut = new Translator($translatorMock);
        $this->assertEquals('Beer', $sut->trans('Bier', [], 'en_EN'));
    }
}
