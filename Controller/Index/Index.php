<?php
namespace Mageplaza\GiftCard\Controller\Index;
/**
 * Class Index
 * @package Mageplaza\GiftCard\Controller\Index
 */
class Index extends \Magento\Framework\App\Action\Action {
    protected $resultPageFactory;
    protected $coreSession;

    /**
     * Index constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Customer\Model\Session $coreSession
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Model\Session $coreSession
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreSession = $coreSession;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute() {
        if($this->coreSession->isLoggedIn()){
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set((__('My Gift Card')));
//        $this->_view->getPage()->getConfig()->getTitle()->set(__('My Gift Card'));
//        $this->_view->renderLayout();
//        $this->_view->loadLayout();
        return $resultPage;
        } else {
            $this->_redirect('customer/account/login');
        }
    }

}
?>