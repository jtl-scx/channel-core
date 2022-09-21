<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Category\Response;

use JTL\SCX\Lib\Channel\Client\Model\CategoryTreeVersion;
use JTL\SCX\Client\Response\AbstractResponse;

class UpdateCategoryTreeResponse extends AbstractResponse
{
    /**
     * @var CategoryTreeVersion
     */
    private $categoryTreeVersion;

    /**
     * UpdateCategoryTreeResponse constructor.
     * @param CategoryTreeVersion $categoryTreeVersion
     */
    public function __construct(int $statusCode, CategoryTreeVersion $categoryTreeVersion)
    {
        $this->categoryTreeVersion = $categoryTreeVersion;
        parent::__construct($statusCode);
    }

    /**
     * @return CategoryTreeVersion
     */
    public function getCategoryTreeVersion()
    {
        return $this->categoryTreeVersion;
    }
}
