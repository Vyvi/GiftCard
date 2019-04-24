<?php

namespace Mageplaza\GiftCard\Controller\Adminhtml\Code;

class Save extends \Magento\Backend\App\Action
{
    protected $_resultPageFactory;
    protected $_giftCardFactory;
    protected $random;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftCardFactory,
        \Magento\Framework\Math\Random $random
    )
    {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->_giftCardFactory = $giftCardFactory;
        $this->random = $random;
    }
    public function add($giftcard,$data){
        $giftcard->addData($data)->save();
    }
    public function  update($giftcard,$id,$data){
        $giftcard->load($id)->addData($data)->save();
    }
    public function generateRandomCode($codelength) {
        $character_lists = 'ABCDEFGHIJKLMLOPQRSTUVXYZ0123456789';
        $charactersLength = strlen($character_lists);
        $randomCode = '';
        for ($i = 0; $i < $codelength; $i++) {
            $randomCode .= $character_lists[rand(0, $charactersLength - 1)];
        }
        return $randomCode;
    }

    public function execute()
    {
        $giftcard = $this->_giftCardFactory->create();
        $id = $this->getRequest()->getParam('id');
        $balance = $this->getRequest()->getParam('balance');
            if ($id==null) { //save new
                $code = $this->generateRandomCode($_POST['codelength']);
//            $code = $this->random->getRandomString($_POST['codelength'], 'ABCDEFGHIJKLMLOPQRSTUVXYZ0123456789');
                $data = [
                    'code' => $code, 'balance' => $balance,'create_from' => 'Admin'
                ];
                $this->add($giftcard, $data);
                $this->messageManager->addSuccess(__('The new Giftcard has been saved.'));
                $this->_redirect('mageplaza_giftcard/code/');
            } else { //save edit

                    $giftcard->load($id);
                    if (!$giftcard->getId()) {
                        $this->messageManager->addError(__('This Giftcard no longer exists.'));
                        $this->_redirect('mageplaza_giftcard/code/');
                    } else {

                    $data = [

                        'balance' => $balance
                    ];
                    $this->update($giftcard, $id, $data);
                    $this->messageManager->addSuccess(__('The Giftcard has been edited.'));
                    $this->_redirect('mageplaza_giftcard/code/');
                    }

            }
            if ($this->getRequest()->getParam('back')) { //save and continue edit
//                var_dump($this->getRequest()->getParams());
//                die('sas');
                $this->_redirect('mageplaza_giftcard/code/edit', ['id' => $giftcard->getId()]);
                return;
            }

    }


}