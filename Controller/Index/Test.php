<?php
namespace Mageplaza\GiftCard\Controller\Index;

class Test extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @var
     */
    protected $_postFactory;
    protected $helperData;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftcardFactory,
        \Mageplaza\GiftCard\Helper\Data $helperData
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_giftcardFactory = $giftcardFactory;
        $this->helperData = $helperData;
        return parent::__construct($context);
    }

    /**
     * @param $giftcard
     * @param $data
     * @return mixed
     */
    public function add($giftcard,$data){
        $giftcard->addData($data)->save();
        echo 'add success'.'<br>';
        echo $data['code'];
//        echo "<pre>";
//        print_r($giftcard->getData());
//        echo "</pre>";
//        echo get_class($giftcard);
        return $giftcard;
    }
    public function  update($giftcard,$id,$data){
        $giftcard->load($id)->addData($data)->save();
    }
    public function  delete($giftcard,$id){
        $giftcard->load($id)->delete();
    }
    public function execute()
    {
        /**
         * @var \Mageplaza\GiftCard\Model\GiftCard $giftcard
         */
        $giftcard = $this->_giftcardFactory->create();
        $collection = $giftcard->getCollection();
//        them->adddata
//        sua->load->add(set)data
//        xoa->load->delete
        $id = 4;
        if($this->helperData->getGeneralConfig('enable') == 1){
        $data = array('code'=>$this->getRequest()->getParam('code'),'balance'=>$this->getRequest()->getParam('balance'));
//        $data = array('code'=>"test789sdds",'balance'=>10000);
            var_dump($this->getRequest()->getParam('code'));
        $this->add($giftcard, $data);
        } else {
            echo "error";
        }

//        var_dump($this->add($giftcard,$data)->getId());
//        echo gettype($giftcard);
//        $this->update($giftcard,$id,$data);
//        $this->delete($giftcard,$id);
//        var_dump($this->delete($giftcard,$id));
//        echo gettype();

//        $giftcard->setData(array('code'=>'sdsadsad1', 'balance'=>10005))->save();
//        $giftcard->load(3)->setData('code','as16611sdds','balance',24000)->save();
//        echo gettype($giftcard->load(3));
//        foreach($collection as $item){
//            echo get_class($item);
//            echo "<pre>";
//            print_r(get_class_methods($item));
//            echo "</pre>";
//            echo "<pre>";
//            print_r($item->getData());
//            echo "</pre>";
//            echo $item->getCode();
//        }

        exit();
        return $this->_pageFactory->create();
    }
}