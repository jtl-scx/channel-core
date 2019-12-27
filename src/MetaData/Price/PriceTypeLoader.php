<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-12-27
 */

namespace JTL\SCX\Lib\Channel\MetaData\Price;

use JTL\SCX\Client\Channel\Model\PriceType;
use JTL\SCX\Lib\Channel\Helper\File\FileHandler;

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


    public function load(string $filename): PriceTypeList
    {
        if (!$this->fileHandler->isFile($filename)) {
            throw new \InvalidArgumentException("{$filename} is not a valid file");
        }

        $priceJson = $this->fileHandler->readContent($filename);
        $priceDataList = json_decode($priceJson, true);

        if (!$this->validateDataList($priceDataList)) {
            throw new \InvalidArgumentException(
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
        $isValid = true;
        if (!is_array($priceDataList)) {
            $isValid = false;
        } else {
            foreach ($priceDataList as $priceData) {
                if (!isset($priceData['priceId']) || !isset($priceData['displayName'])) {
                    return false;
                }
            }
        }

        return $isValid;
    }
}