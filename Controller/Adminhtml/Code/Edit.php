<?php

namespace Mageplaza\GiftCard\Controller\Adminhtml\Code;

class Edit extends \Magento\Backend\App\Action
{
    protected $_resultPageFactory;
    protected $_giftCardFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftCardFactory
    )
    {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->_giftCardFactory = $giftCardFactory;
    }

    public function execute()
    {
//        $a=1;
//        $this->registry->register('a',$a);
        $resultPage = $this->_resultPageFactory->create();
        $giftcard = $this->_giftCardFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $giftcard->load($id);
            if (!$giftcard->getId()) {
                $this->messageManager->addError(__('This Giftcard no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        if (isset($id)&&$id!=null){
            $resultPage->getConfig()->getTitle()->prepend((__('Edit giftcard'." ".$giftcard->load($id)->getCode())));
        } else{
            $resultPage->getConfig()->getTitle()->prepend((__('Add new giftcard')));
        }
        return $resultPage;
    }


}