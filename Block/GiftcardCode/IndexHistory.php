<?php
namespace Mageplaza\GiftCard\Block\GiftcardCode;
use Magento\Framework\View\Element\Template;

/**
 * Class IndexHistory
 * @package Mageplaza\GiftCard\Block\GiftcardCode
 */
class IndexHistory extends Template
{
    protected $_giftCardHistoryFactory;
    protected $_giftCardFactory;
    protected $_coreSession;

    /**
     * IndexHistory constructor.
     * @param Template\Context $context
     * @param \Mageplaza\GiftCard\Model\GiftCardFactory $giftCardFactory
     * @param \Magento\Customer\Model\Session $coreSession
     * @param \Mageplaza\GiftCard\Model\GiftCardHistoryFactory $giftCardHistoryFactory
     */
    public function __construct(
        Template\Context $context,
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftCardFactory,
        \Magento\Customer\Model\Session $coreSession,
        \Mageplaza\GiftCard\Model\GiftCardHistoryFactory $giftCardHistoryFactory
    )
    {
        $this->_giftCardFactory = $giftCardFactory;
        $this->_giftCardHistoryFactory = $giftCardHistoryFactory;
        $this->_coreSession = $coreSession;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getHistory()
    {
        $history = $this->_giftCardHistoryFactory->create();
        $collection = $history->getCollection();
        $customerId = $this->_coreSession->getCustomer()->getData('entity_id');
        $collection->addFieldToFilter('customer_id', $customerId)->setOrder('history_id', 'DESC');
        return $collection->getData();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCode($id)
    {
        $giftCard = $this->_giftCardFactory->create();
        return $giftCard->load($id)->getData('code');
    }
}