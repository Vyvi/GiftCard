<?php
namespace Mageplaza\GiftCard\Model;
class GiftCard extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'mageplaza_giftcard_code';

    protected $_cacheTag = 'mageplaza_giftcard_code';

    protected $_eventPrefix = 'mageplaza_giftcard_code';

    protected function _construct()
    {
        $this->_init('Mageplaza\GiftCard\Model\ResourceModel\GiftCard');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [

        ];

        return $values;
    }

}