<?php

namespace Magestore\OneStepCheckout\Plugin\Checkout\Onepage;

class Link extends \Magento\Framework\View\Element\Template {


    /**
     * @return string
     */
    public function afterGetCheckoutUrl() {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        

        // var_dump($this->getUrl('checkout'));
        // die('xxx');


        // controllo se l'utente è loggato
        if ( $customerSession->isLoggedIn() ) {


            // se loggato lo mando al checkout

            return $this->getUrl('checkout');


        } else {


            // se non loggato lo mando al bivio di login, 
            // settando in sessione un parametro che mi dice
            // che è passato dal carrello

            $customerSession->setData('passed_from_cart', true);

            return $this->getUrl('customer/account/login');

        }

    }

}