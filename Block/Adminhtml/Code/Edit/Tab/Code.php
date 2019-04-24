<?php
namespace Mageplaza\GiftCard\Block\Adminhtml\Code\Edit\Tab;
class Code extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $helperData;
    public function __construct(
    \Magento\Backend\Block\Template\Context $context,
    \Magento\Framework\Registry $registry,
    \Magento\Framework\Data\FormFactory $formFactory,
    \Mageplaza\GiftCard\Helper\Data $helperData,
    \Mageplaza\GiftCard\Model\GiftCardFactory $giftCardFactory,
    array $data = []
)
{
    $this->helperData = $helperData;
    $this->_giftCardFactory = $giftCardFactory;
    parent::__construct($context, $registry, $formFactory, $data);
}
protected function _prepareForm()
{
//    $this->_coreRegistry->registry('a');
    var_dump($this->getRequest()->getParam('id'));
    $id = $this->getRequest()->getParam('id');
//        die('sdad')
        $form = $this->_formFactory->create();
        $this->setForm($form);
        $codelength = $this->helperData->getCodeConfig('code_length');
        if ($id==null){
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add new GiftCard')]
            );

//    if ($model->getId()) {
//        $fieldset->addField(
//            'id',
//            'hidden',
//            ['name' => 'id']
//        );
//    }
            $fieldset->addField(
                'codelength',
                'text',
                [
                    'name'        => 'codelength',
                    'label'    => __('Code Length'),
                    'required'     => true,
                    'value' => $codelength,

                ]
            );
            $fieldset->addField(
                'balance',
                'text',
                [
                    'name'        => 'balance',
                    'label'    => __('Balance'),
                    'required'     => true
                ]
            );
        } else {
            $giftcard = $this->_giftCardFactory->create();
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit GiftCard')]
            );

//    if ($model->getId()) {
//        $fieldset->addField(
//            'id',
//            'hidden',
//            ['name' => 'id']
//        );
//    }
            $fieldset->addField(
                'id',
                'hidden',
                [
                    'name'        => 'id',
                    'label'    => __('GiftCard Id'),
                    'value'     => $giftcard->load($id)->getData('giftcard_id'),
                    'required'     => true,
                    'readonly' => true
                ]
            );
            $fieldset->addField(
                'code',
                'text',
                [
                    'name'        => 'code',
                    'label'    => __('GiftCard Code'),
                    'value'     => $giftcard->load($id)->getData('code'),
                    'required'     => true,
                    'readonly' => true
                ]
            );
            $fieldset->addField(
                'balance',
                'text',
                [
                    'name'        => 'balance',
                    'label'    => __('Balance'),
                    'value'     => $giftcard->load($id)->getData('balance'),
                    'required'     => true

                ]
            );
            $fieldset->addField(
                'create_from',
                'text',
                [
                    'name'        => 'create_from',
                    'label'    => __('Create from'),
                    'required'     => false,
                    'value'     => $giftcard->load($id)->getData('create_from'),
                    'readonly' => true
                ]
            );
        }


        return parent::_prepareForm();


}
public function getTabLabel()
{
    return __('Gift card information');
}
public function getTabTitle()
{
    return $this->getTabLabel();
}
public function canShowTab()
{
    return true;
}
public function isHidden()
{
    return false;
}
}