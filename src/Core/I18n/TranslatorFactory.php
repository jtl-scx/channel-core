<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 10/28/20
 */

namespace JTL\SCX\Lib\Channel\Core\I18n;

use RuntimeException;
use Symfony\Component\Translation\Loader\YamlFileLoader;

class TranslatorFactory
{
    public function createTranslator(string $translationsDir, string $defaultLocale): Translator
    {
        $translator = new \Symfony\Component\Translation\Translator($defaultLocale);
        $translator->addLoader('yaml', new YamlFileLoader());

        $path = (string)realpath($translationsDir);
        if (!is_dir($path)) {
            throw new RuntimeException(
                "Parameter \$translationDir '{$path}' is not a directory"
            );
        }

        foreach (glob("{$path}/*.yaml") as $path) {
            $filename = basename($path);
            $translator->addResource('yaml', $path, explode('.', $filename)[0]);
        }

        return new Translator($translator);
    }
}
