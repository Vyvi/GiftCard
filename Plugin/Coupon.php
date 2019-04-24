<?php
namespace Mageplaza\GiftCard\Plugin;
class Coupon
{
    protected $_checkoutSession;
    protected $request;
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $this->_checkoutSession = $checkoutSession;
        $this->request = $request;
    }

    /**
     * @param \Magento\Checkout\Block\Cart\Coupon $subject
     * @param $result
     * @return mixed
     */
    public function afterGetCouponCode(\Magento\Checkout\Block\Cart\Coupon $subject, $result)
    {
        // change coupon display
        if ($this->_checkoutSession->getGiftcardCode()) {
            return $this->_checkoutSession->getGiftcardCode();
        } else {
            return $result;
        }
    }
}