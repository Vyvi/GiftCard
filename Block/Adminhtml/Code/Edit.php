<?php
namespace Mageplaza\GiftCard\Block\Adminhtml\Code;
class Edit extends\Magento\Backend\Block\Widget\Form\Container
{
    protected $_coreRegistry;
    public function __construct(
    \Magento\Framework\Registry $coreRegistry,
    \Magento\Backend\Block\Widget\Context $context,
    array $data = []
    )
    {
    $this->_coreRegistry = $coreRegistry;
    parent::__construct($context, $data);
    }
    protected function _construct()
    {

//        var_dump($this->getRequest()->getParams());
//        die('sdad');
    $this->_objectId = 'id';
    $this->_blockGroup = 'Mageplaza_GiftCard';
    $this->_controller = 'adminhtml_code';
    parent::_construct();
//        $this->buttonList->update('save', 'label', __('Save'));
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            -100
        );
//        $this->buttonList->update('delete', 'label', __('Delete'));
//        die('dsads');
    }
}