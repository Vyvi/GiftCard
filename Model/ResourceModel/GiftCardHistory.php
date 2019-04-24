<?php

namespace Mageplaza\GiftCard\Model\ResourceModel;


use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class GiftCardHistory
 * @package Mageplaza\GiftCard\Model\ResourceModel
 */
class GiftCardHistory extends AbstractDb
{
    /**
     * GiftCardHistory constructor.
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    /**
     *
     */
    protected function _construct()
    {
        $this->_init('giftcard_history', 'history_id');
    }
}