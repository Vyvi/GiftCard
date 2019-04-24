<?php
namespace Mageplaza\GiftCard\Observer;
use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;
class Cost implements ObserverInterface
{
    //update amount used va luong con lai cua gift card
    // reddem luong balance - amount used

    protected $giftcardModel;
    protected $checkoutSession;
    public function __construct(
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftcardModel,
        \Magento\Checkout\Model\Session $checkoutSession
    )
    {
        $this->giftcardModel = $giftcardModel;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        //get data event TODO

    }
}