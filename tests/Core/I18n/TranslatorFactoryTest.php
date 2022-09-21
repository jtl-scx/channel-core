<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 10/28/20
 */

namespace JTL\SCX\Lib\Channel\Core\I18n;

use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\I18n\TranslatorFactory
 */
class TranslatorFactoryTest extends TestCase
{
    public function testItCanTranslateString()
    {
        $factory = new TranslatorFactory();

        $sut = $factory->createTranslator(__DIR__ . '/../../../translations', 'de_DE');
        $this->assertEquals('Bier', $sut->trans('Beer'));
    }

    public function testItFailWhenTranslationDirIsNotDirectory()
    {
        $factory = new TranslatorFactory();

        $this->expectException(RuntimeException::class);
        $factory->createTranslator(__DIR__ . '/foo/bar/baz', 'de_DE');
    }
}
