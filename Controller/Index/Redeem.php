<?php
namespace Mageplaza\GiftCard\Controller\Index;
/**
 * Class Redeem
 * @package Mageplaza\GiftCard\Controller\Index
 */
class

Redeem extends \Magento\Framework\App\Action\Action
{
    protected $_giftCardFactory;
    protected $_giftCardHistoryFactory;
    protected $customerResource;
    protected $customerFactory;
    protected $_coreSession;

    /**
     * Redeem constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Mageplaza\GiftCard\Model\GiftCardFactory $giftCardFactory
     * @param \Mageplaza\GiftCard\Model\GiftCardHistoryFactory $giftCardHistoryFactory
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param \Magento\Customer\Model\Session $coreSession
     * @param \Magento\Customer\Model\ResourceModel\Customer $customerResource
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftCardFactory,
        \Mageplaza\GiftCard\Model\GiftCardHistoryFactory $giftCardHistoryFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\Session $coreSession,
        \Magento\Customer\Model\ResourceModel\Customer $customerResource
    )
    {
        $this->_giftCardFactory = $giftCardFactory;
        $this->_giftCardHistoryFactory = $giftCardHistoryFactory;
        $this->customerResource = $customerResource;
        $this->customerFactory = $customerFactory;
        $this->_coreSession = $coreSession;
        return parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $giftCard = $this->_giftCardFactory->create();
        $history = $this->_giftCardHistoryFactory->create();
        $customer = $this->customerFactory->create();
        $customerId = $this->_coreSession->getCustomer()->getData()['entity_id'];
        $customer->load($customerId);
        $success = False;
        $item = $giftCard->load($this->getRequest()->getParam('redeem'), 'code')->getData();
        $cond = $giftCard->load($this->getRequest()->getParam('redeem'), 'code')->getData('giftcard_id');

        $amount_redeem = $this->getRequest()->getParam('amount_redeem');
        if (isset($cond)) {
            //check amount used
            if ($item['balance'] - $item['amount_used'] > 0 && $amount_redeem <= $item['balance'] - $item['amount_used']) {
                // add history
                $data = array('giftcard_id' => $item['giftcard_id'], 'customer_id' => $customerId, 'amount' => $amount_redeem, 'action' => 'redeem');
                $history->addData($data)->save();
                //add customer_entity
                $balance = $customer->getData()['giftcard_balance'] + ($amount_redeem);
                $customer->addData(array('giftcard_balance' => $balance));
                $this->customerResource->getConnection()->update(
                    $this->customerResource->getTable('customer_entity'),
                    [
                        'giftcard_balance' => $balance,
                    ],
                    $this->customerResource->getConnection()->quoteInto('entity_id = ?', $customerId)
                );

                //add giftcard amount used
                $giftCard->addData(array('amount_used' => $item['amount_used']+$amount_redeem))->save();
                //success
                $success = True;
            }
        }
        if ($success) {
            $this->messageManager->addSuccess(__('The code has been redeem.'));
        } else {
            $this->messageManager->addError(__('The code no longer exists or used'));
        }
        $this->_redirect('giftcard');
    }
}