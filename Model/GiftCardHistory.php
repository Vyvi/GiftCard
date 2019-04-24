<?php
namespace Mageplaza\GiftCard\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class GiftCardHistory
 * @package Mageplaza\GiftCard\Model
 */
    class GiftCardHistory extends AbstractModel
    {
        /**
         *
         */
        protected function _construct()
        {
            $this->_init('Mageplaza\GiftCard\Model\ResourceModel\GiftCardHistory');

        }

        /**
         * @return array
         */
        public function getIdentities()
        {
            return [self::CACHE_TAG . '_' . $this->getId()];
        }

        /**
         * @return array
         */
        public function getDefaultValues()
        {
            $values = [

            ];

            return $values;
        }
    }