<?php

namespace Mageplaza\GiftCard\Model\Total\Quote;
class Custom extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    protected $_priceCurrency;
    protected $_checkoutSession;
    protected $giftCard;

    public function __construct(
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftCard,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    )
    {
        $this->giftCard = $giftCard;
        $this->_checkoutSession = $checkoutSession;
        $this->_priceCurrency = $priceCurrency;

    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this|\Magento\Quote\Model\Quote\Address\Total\AbstractTotal
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);

//        $this->_checkoutSession->getQuote()->collectTotals()->save();
        // re_create value giftcard session
        if ($this->_checkoutSession->getGiftcardCode()) {
            $giftCardCode = $this->_checkoutSession->getGiftcardCode();
            $giftCard = $this->giftCard->create();
            $amount = $giftCard->load($giftCardCode, 'code')->getData('balance');
            $amountUsed = $giftCard->load($giftCardCode, 'code')->getData('amount_used');
            //settting base discount

            if (($amount - $amountUsed) <= $total->getGrandTotal()) {
                $baseDiscount = $amount - $amountUsed; //giftcard_amount_can_be_use
            } else {
                $baseDiscount = $total->getGrandTotal();
            }

            $this->_checkoutSession->setGiftCardAmount($baseDiscount);
            $discount = $this->_priceCurrency->convert($baseDiscount);
//        echo $total->getBaseGrandTotal();
//        echo $total->getGrandTotal();
            //caculate in quote
            $total->setCustomerDiscount($discount);
            $total->setGrandTotal($total->getGrandTotal() - $total->getCustomerDiscount());
        } else {
            $this->_checkoutSession->setGiftCardAmount(0);
        }
//        echo $this->_checkoutSession->getGiftCardAmount();
//        if($total->getGrandTotal() < 0){
//            $total->setGrandTotal(floatval(0));
//        }
//        echo $total->getGrandTotal();
//        die('sđá');
        return $this;


    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return array|null
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {

        $result = null;
        $amount = $this->_checkoutSession->getGiftCardAmount();

        $giftCardCode = $this->_checkoutSession->getGiftcardCode();

        if ($amount != 0) {
            $result = [
                'code' => 'customer_discount',
                'title' => __('<i><b>G</b>ift<b>C</b>ard ' . '<u>' . $giftCardCode . '</u>' . '</i>'),
                'value' => -$amount,
            ];
        }
        return $result;
    }
}