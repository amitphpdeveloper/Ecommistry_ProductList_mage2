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
namespace Ecommistry\ProductList\Block\Product\ProductList;


/**
 * Ecommistry ProductList toolbar
 *
 * @author  EcommistryTeam <support@ecommistry.com>
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{
	
	 /**
     * Retrieve available view modes
     *
     * @return array
     */
    public function getModes()
    {
        if ($this->_availableMode === []) {
            $this->_availableMode = ['grid' => __('Grid'), 'slider' =>  __('Slider')];
        };
        return $this->_availableMode;
    }
	
	/**
     * Retrieve current View mode
     *
     * @return string
     */
    public function getCurrentMode()
    {
        $mode = $this->_getData('_current_grid_mode');
		if ($mode) {
            return $mode;
        }
        $defaultMode = $this->_productListHelper->getDefaultViewMode($this->getModes());
		
        $mode = $this->_toolbarModel->getMode();
	    
		if($mode == 'slider')
		{
			return $mode;
		}
		
		if (!$mode || !isset($this->_availableMode[$mode])) {
            $mode = $defaultMode;
        }

		
        $this->setData('_current_grid_mode', $mode);
        return $mode;
    }
	
	/**
     * Set collection to pager
     *
     * @param \Magento\Framework\Data\Collection $collection
     * @return $this
     */
    public function setCollection($collection)
    {
		$this->_collection = $collection;

        $this->_collection->setCurPage($this->getCurrentPage());

    	$limit = $this->getProductLimit();
        if ($limit) {
            $this->_collection->setPageSize($limit);
        }
        if ($this->getCurrentOrder()) {
            $this->_collection->setOrder($this->getCurrentOrder(), $this->getCurrentDirection());
        }
        return $this;
    }
	
	/**
     * Compare defined view mode with current active mode
     *
     * @param string $mode
     * @return bool
     */
    public function isModeActive($mode)
    {
	    return $this->getCurrentMode() == $mode;
    }
	
	
	    /* Get the configured limit of products */

    public function getProductLimit() {
        return $this->_scopeConfig->getValue('product_list/frontend_setting/show_product', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
	
	/**
     * Render pagination HTML
     *
     * @return string
     */
    public function getPagerHtml()
    {
        $pagerBlock = $this->getChildBlock('product_list_toolbar_pager');

        if ($pagerBlock instanceof \Magento\Framework\DataObject) {
            /* @var $pagerBlock \Magento\Theme\Block\Html\Pager */
            $pagerBlock->setAvailableLimit($this->getAvailableLimit());

            $pagerBlock->setUseContainer(
                false
            )->setShowPerPage(
                false
            )->setShowAmounts(
                false
            )->setFrameLength(
                $this->_scopeConfig->getValue(
                    'design/pagination/pagination_frame',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                )
            )->setJump(
                $this->_scopeConfig->getValue(
                    'design/pagination/pagination_frame_skip',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                )
            )->setLimit(
                $this->getLimit()
            )->setCollection(
                $this->getCollection()
            );

            return $pagerBlock->toHtml();
        }

        return '';
    }
}
