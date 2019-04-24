<?php
namespace Mageplaza\GiftCard\Controller\Index;
/**
 * Class Cart
 * @package Mageplaza\GiftCard\Controller\Index
 */
class Cart extends \Magento\Framework\App\Action\Action
{
    protected $_checkoutSession;
    protected $orderFactory;
    protected $product;
    protected $helperData;
    protected $giftcardModel;
    protected $random;

    /**
     * Cart constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Mageplaza\GiftCard\Helper\Data $helperData
     * @param \Magento\Catalog\Model\ProductFactory $product
     * @param \Mageplaza\GiftCard\Model\GiftCardFactory $giftcardModel
     * @param \Magento\Framework\Math\Random $random
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Mageplaza\GiftCard\Helper\Data $helperData,
        \Magento\Catalog\Model\ProductFactory $product,
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftcardModel,
        \Magento\Framework\Math\Random $random
    )
    {
        $this->giftcardModel = $giftcardModel;
        $this->random = $random;
        $this->_checkoutSession = $checkoutSession;
        $this->orderFactory = $orderFactory;
        $this->product = $product;
        $this->helperData = $helperData;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Checkout\Model\Session
     */
    public function getCheckoutSession()
    {
        return $this->_checkoutSession;
    }

    /**
     * @param $length
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function randomCodeWithLength($length)
    {
        $str = 'ABCDEFGHIJKLMLOPQRSTUVXYZ0123456789';
        return $this->random->getRandomString($length, $str);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(){
////        echo $this->getCheckoutSession()->getQuoteId();
////        print_r($this->getCheckoutSession()->getQuote()->getData('order_id'));
////          var_dump($this->_checkoutSession->getData());
//        $order = $this->orderFactory->create()->loadByIncrementId(000000012);
//        var_dump($order);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');
// get quote items array
        //item la sp trong kho
        //product la san pham trong card
        $items = $cart->getQuote()->getAllItems();
        foreach($items as $item) {
            echo '<pre>';
            print_r($cart->getQuote()->getIncrementId());
            echo '</pre>';
            echo 'ID: ' . $item->getProductId() . '<br />';
            echo 'Name: ' . $item->getName() . '<br />';
            echo 'Sku: ' . $item->getSku() . '<br />';
            echo 'Quantity: ' . $item->getQty() . '<br />';
            echo 'Price: ' . $item->getPrice() . '<br />';
            echo 'Type: ' . $item->getProductType() . '<br />';
            echo 'Amount: ' . $item->getData('giftcard_amount') . '<br />';
            echo "<br />";
        }

        foreach ($items as $item) {
            $product = $this->product->create();
            $productId = $item->getProductId();
            var_dump($productId);
            $balance = $product->load($productId)->getData('giftcard_amount');
            var_dump($product->load($productId)->getGiftcartAmount());
            die('sdasd');
            if ($item->getIsVirtual() && $balance > 0) {
                $quantity = $item->getQty();
                $length = $this->helperData->getCodeConfig('code_length');
                $createFrom = 'Order #007';
                for ($i = 0; $i < $quantity; $i++) {
                    //create new code
                    $giftcardModel = $this->giftcardModel->create();
                    $code = $this->randomCodeWithLength($length);
                    $giftcardModel->addData(array('code' => $code, 'balance' => $balance, 'create_from' => $createFrom))->save();
                    //add history
//                    $history = $this->history->create();
//                    $giftcardId = $giftcardModel->getID();
//                    $data = array('giftcard_id' => $giftcardId, 'customer_id' => 1, 'amount' => $balance, 'action' => 'create #007');
//                    $history->addData($data)->save();
                }
            }
        }
        }

}