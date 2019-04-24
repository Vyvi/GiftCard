<?php

namespace Mageplaza\GiftCard\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Mageplaza\GiftCard\Helper
 */
class Data extends AbstractHelper
{

    const XML_PATH_GIFTCARD = 'giftcard/';

    /**
     * @param $field
     * @param null $storeId
     * @return mixed
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    /**
     * @param $code
     * @param null $storeId
     * @return mixed
     */
    public function getGeneralConfig($code, $storeId = null)
    {

        return $this->getConfigValue(self::XML_PATH_GIFTCARD .'general/'. $code, $storeId);
    }

    /**
     * @param $code
     * @param null $storeId
     * @return mixed
     */
    public function getCodeConfig($code, $storeId = null)
    {

        return $this->getConfigValue(self::XML_PATH_GIFTCARD .'code/'. $code, $storeId);
    }

}