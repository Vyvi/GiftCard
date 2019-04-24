<?php

namespace Mageplaza\GiftCard\Controller\Adminhtml\Code;

class NewAction extends \Magento\Backend\App\Action
{
    protected $_resultForwardFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    )
    {
        parent::__construct($context);
        $this->_resultForwardFactory = $resultForwardFactory;
    }

    public function execute()
    {

        $resultPage = $this->_resultForwardFactory->create();
//        $resultPage->getConfig()->getTitle()->prepend((__('Add new giftcard')));
        $resultPage->forward('edit');

        return $resultPage;
    }


}