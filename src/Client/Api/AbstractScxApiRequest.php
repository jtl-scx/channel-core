<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/8/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api;

use JTL\SCX\Client\Request\ScxApiRequest;

abstract class AbstractScxApiRequest implements ScxApiRequest
{
    public function getContentType(): string
    {
        return ScxApiRequest::CONTENT_TYPE_JSON;
    }

    public function getAdditionalHeaders(): array
    {
        return [];
    }

    public function getParams(): array
    {
        return [];
    }

    public function getBody(): ?string
    {
        return '';
    }
}
