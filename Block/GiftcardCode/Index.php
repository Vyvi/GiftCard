<?php
namespace Mageplaza\GiftCard\Block\GiftcardCode;
use Magento\Framework\View\Element\Template;

/**
 * Class Index
 * @package Mageplaza\GiftCard\Block\GiftcardCode
 */
class Index extends Template
{
    protected $helperData;
    protected $_coreSession;

    /**
     * Index constructor.
     * @param Template\Context $context
     * @param \Magento\Customer\Model\Session $coreSession
     * @param \Mageplaza\GiftCard\Helper\Data $helperData
     */
    public function __construct(
        Template\Context $context,
        \Magento\Customer\Model\Session $coreSession,
        \Mageplaza\GiftCard\Helper\Data $helperData
    )
    {
        $this->helperData = $helperData;
        $this->_coreSession = $coreSession;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {

        return $this->_coreSession->getCustomer()->getData('giftcard_balance');
    }

    /**
     * @return mixed
     */
    public  function isRedeemAllowed(){
        return $this->helperData->getGeneralConfig('enable_redeem');
    }
}