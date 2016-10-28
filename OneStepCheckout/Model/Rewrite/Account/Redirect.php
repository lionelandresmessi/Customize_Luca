<?php

/**
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_OneStepCheckout
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

namespace Magestore\OneStepCheckout\Model\Rewrite\Account;

use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Store\Model\ScopeInterface;


class Redirect extends \Magento\Customer\Model\Account\Redirect {


    /**
     * Prepare redirect URL for logged in customer
     *
     * Redirect customer to the last page visited after logging in.
     *
     * @return void
     */
    protected function processLoggedCustomer() {

            
        /*
         * controllo in sessione se sono passato dal carrello,
         * cosi da mandare l'utente direttamente al osc e non nel my account
         */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        
        if ( $customerSession->getData('passed_from_cart') ) {

            /* 
             * todo
             * controllare se sono stati uniti i 2 carrelli vecchio e nuovo,
             * nel caso redirigere nuovamente al carrello!!!
             */

            $this->applyRedirect($this->customerUrl->getOscUrl());

        } else {

            $this->applyRedirect($this->customerUrl->getAccountUrl());
            
        }


        // questo codice è quello della funzione padre originale
        if (
            !$this->scopeConfig->isSetFlag(
                CustomerUrl::XML_PATH_CUSTOMER_STARTUP_REDIRECT_TO_DASHBOARD,
                ScopeInterface::SCOPE_STORE
            )
        ) {

            $referer = $this->request->getParam(CustomerUrl::REFERER_QUERY_PARAM_NAME);
            
            if ($referer) {

                $referer = $this->urlDecoder->decode($referer);
            
                if ($this->url->isOwnOriginUrl()) {
            
                    $this->applyRedirect($referer);
            
                }
            
            }
        
        } elseif ($this->session->getAfterAuthUrl()) {
        
            $this->applyRedirect($this->session->getAfterAuthUrl(true));
        
        }
        
    }



    /**
     * Prepare redirect URL
     *
     * @param string $url
     * @return void
     */
    private function applyRedirect($url) {

        $this->session->setBeforeAuthUrl($url);

    }    

}