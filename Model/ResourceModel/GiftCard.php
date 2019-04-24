<?php
namespace Mageplaza\GiftCard\Model\ResourceModel;


class GiftCard extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('mageplaza_giftcard_code', 'giftcard_id');
    }

}