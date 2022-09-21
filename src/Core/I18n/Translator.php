<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 10/28/20
 */

namespace JTL\SCX\Lib\Channel\Core\I18n;

use Symfony\Contracts\Translation\TranslatorInterface;

class Translator
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function trans(string $id, array $parameters = [], $locale = null): string
    {
        return $this->translator->trans($id, $parameters, null, $locale);
    }
}
