<?php

/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magestore\OneStepCheckout\Plugin\Customer\Block\Form\Login;


/**
 * Customer login info block
 */
class Info extends \Magento\Customer\Block\Form\Login\Info {


    /** 
     *
     */   
    public function afterGetCreateAccountUrl() {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $cartData = $objectManager->get('Magento\Checkout\Model\Cart')
            ->getQuote()
            ->getAllVisibleItems();

        

        // var_dump(count($cartData));
        // die;


        $url = $this->getData('create_account_url');
        if ($url === null) {

            if ( count($cartData) > 0) {


                // $customerSession = $objectManager->get('Magento\Customer\Model\Session');
                // var_dump($customerSession->getData('passed_from_cart'));
                // die('xxx');


                // se ho prodotti nel carrello lo mando al checkout
                return $this->_urlBuilder->getUrl('checkout');
            
            } else {

                $url = $this->_customerUrl->getRegisterUrl();
            
            }
            
            $url = $this->_customerUrl->getRegisterUrl();
        
        }

        if ( $this->checkoutData->isContextCheckout() ) {

            $url = $this->coreUrl->addRequestParam($url, ['context' => 'checkout']);

        }

        return $url;

    }

}