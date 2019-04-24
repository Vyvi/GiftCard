<?php

namespace Mageplaza\GiftCard\Controller\Adminhtml\Code;

class Delete extends \Magento\Backend\App\Action
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
    public function delete($giftcard,$id){
        $giftcard->load($id)->delete();
    }


    public function execute()
    {
//        $giftcard = $this->_giftCardFactory->create();
//        $id = $this->getRequest()->getParam('id');
//        if (!$id) {
//            $this->messageManager->addError(__('This Giftcard no longer exists.'));
//            $this->_redirect('mageplaza_giftcard/code/');
//        } else {
//            $this->delete($giftcard, $id);
//            $this->messageManager->addSuccess(__('The Giftcard has been deleted.'));
//            $this->_redirect('mageplaza_giftcard/code/');
//        }
        $id = $this->getRequest()->getParam('id');
        if ($id) {

            $giftcard = $this->_giftCardFactory->create();
            $giftcard->load($id);

            // Check this giftcard exists or not
            if (!$giftcard->getId()) {
                $this->messageManager->addError(__('This Giftcard no longer exists.'));
                $this->_redirect('*/*/');
            } else {
                try {
                    // Delete
                    $giftcard->delete();
                    $this->messageManager->addSuccess(__('The Giftcard has been deleted.'));
                    $this->_redirect('*/*/');
                    return;
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                    $this->_redirect('*/*/edit', ['id' => $giftcard->getId()]);
                }
            }
        }
    }


}