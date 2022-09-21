<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-12-27
 */

namespace JTL\SCX\Lib\Channel\MetaData\Price;

use InvalidArgumentException;
use JTL\SCX\Lib\Channel\Client\Model\PriceType;
use JTL\SCX\Lib\Channel\Helper\FileHandler;

class PriceTypeLoader
{
    /**
     * @var FileHandler
     */
    private $fileHandler;

    public function __construct(FileHandler $fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

    /**
     * @param string $filename
     * @return PriceTypeList
     */
    public function load(string $filename): PriceTypeList
    {
        if (!$this->fileHandler->isFile($filename)) {
            throw new InvalidArgumentException("'{$filename}' is not a valid file");
        }

        $priceJson = $this->fileHandler->readContent($filename);
        $priceDataList = json_decode($priceJson, true);

        if (!$this->validateDataList($priceDataList)) {
            throw new InvalidArgumentException(
                "Could not decode json or json does not contain valid price-data. Minimum is 'priceId' and 'displayName'"
            );
        }

        $priceTypeList = new PriceTypeList();
        foreach ($priceDataList as $priceData) {
            $priceType = new PriceType();
            $priceType->setPriceTypeId($priceData['priceId']);
            $priceType->setDisplayName($priceData['displayName']);
            if (isset($priceData['description'])) {
                $priceType->setDescription($priceData['description']);
            }
            $priceTypeList[] = $priceType;
        }

        return $priceTypeList;
    }

    private function validateDataList($priceDataList): bool
    {
        if (!is_array($priceDataList) || empty($priceDataList)) {
            return false;
        }
        foreach ($priceDataList as $priceData) {
            if (!isset($priceData['priceId']) || !isset($priceData['displayName'])) {
                return false;
            }
        }

        return true;
    }
}
