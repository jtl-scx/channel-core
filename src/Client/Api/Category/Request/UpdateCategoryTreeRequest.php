<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Category\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\ChannelCategoryTree;
use JTL\SCX\Client\Request\ScxApiRequest;

class UpdateCategoryTreeRequest extends AbstractScxApiRequest
{
    private ChannelCategoryTree $channelCategoryTree;

    /**
     * UpdateCategoryTreeRequest constructor.
     * @param ChannelCategoryTree $channelCategoryTree
     */
    public function __construct(ChannelCategoryTree $channelCategoryTree)
    {
        $this->channelCategoryTree = $channelCategoryTree;
    }

    public function getChannelCategoryTree(): ChannelCategoryTree
    {
        return $this->channelCategoryTree;
    }

    public function getUrl(): string
    {
        return '/v1/channel/categories';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_PUT;
    }

    public function getBody():string
    {
        return (string)$this->getChannelCategoryTree();
    }
}
