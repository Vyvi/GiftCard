<?php

namespace Mageplaza\GiftCard\Controller\Index;
/**
 * Class Config
 * @package Mageplaza\GiftCard\Controller\Index
 */
class Config extends \Magento\Framework\App\Action\Action
{

    protected $helperData;

    /**
     * Config constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Mageplaza\GiftCard\Helper\Data $helperData
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Mageplaza\GiftCard\Helper\Data $helperData

    )
    {
        $this->helperData = $helperData;
        return parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {

        // TODO: Implement execute() method.

        echo $this->helperData->getGeneralConfig('enable');
        echo $this->helperData->getGeneralConfig('enable_checkout');
        echo $this->helperData->getGeneralConfig('enable_redeem');
        echo $this->helperData->getCodeConfig('code_length');
        exit();

    }
}