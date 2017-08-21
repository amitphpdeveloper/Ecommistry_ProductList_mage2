<?php
/**
 * Product listing for customer account
 * Copyright (C) 2017  Ecommistry
 * 
 * This file included in Ecommistry/ProductList is licensed under OSL 3.0
 * 
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace Ecommistry\ProductList\Controller\Index;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Customer\Model\Session;

class Index extends \Magento\Framework\App\Action\Action 
{
	
	 /**
     * @var PageFactory
     */
    protected $resultPageFactory;
	/**
     * @param Context $context
     * @param Session $customerSession
     * @param PageFactory $resultPageFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param DataObjectHelper $dataObjectHelper
     */
	 
    public function __construct(
        Context $context,
        Session $customerSession,
        PageFactory $resultPageFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->session = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
         $this->scopeConfig = $scopeConfig;
		
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context);
    }

   

    /**
     * Execute productlist view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
	
	   if(!$this->scopeConfig->getValue('product_list/general_setting/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE))
	   {
		   $this->_redirect('404');
	   }
	
	
        $resultPage = $this->resultPageFactory->create();
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $customerSession = $objectManager->get('\Magento\Customer\Model\Session');
         $urlInterface = $objectManager->get('\Magento\Framework\UrlInterface');
		
		if(!$customerSession->isLoggedIn()) {
			$customerSession->setAfterAuthUrl($urlInterface->getCurrentUrl());
			$customerSession->authenticate();
		}
		
		
		$this->_view->loadLayout();

		$resultPage->getConfig()->getTitle()->set(__('Ecommistry ProductList'));
        $resultPage->getLayout()->getBlock('messages')->setEscapeMessageFlag(true);
      
		 
		 
        $this->_view->renderLayout();
       
    }
}
