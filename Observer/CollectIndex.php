<?php
namespace Mageplaza\GiftCard\Observer;
use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;
class CollectIndex implements ObserverInterface
{

    protected $_checkoutSession;

    public function __construct(

        \Magento\Checkout\Model\Session $checkoutSession

    )
    {

        $this->_checkoutSession = $checkoutSession;

    }

    public function execute(Observer $observer)
    {

            $this->_checkoutSession->getQuote()->collectTotals();

    }
}