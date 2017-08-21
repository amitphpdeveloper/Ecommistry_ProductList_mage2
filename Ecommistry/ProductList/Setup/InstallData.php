<?php
/**
 * Ecommistry Product listing for customer account
 * Copyright (C) 2017  Ecommistry
 * 
 * This file included in Ecommistry/ProductList is licensed under OSL 3.0
 * 
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace Ecommistry\ProductList\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

class InstallData implements InstallDataInterface
{

    private $eavSetupFactory;

    /**
     * Constructor
     *
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
       $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY,'handle_display');
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'handle_display',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Handle Display',
                'input' => 'boolean',
                'class' => '',
                'source' => '',
                'global' => 1,
                'visible' => true,
                'required' => true,
                'user_defined' => true,
                'default' => null,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => '',
                'system' => 1,
                'group' => 'Ecommistry ProductList Attribute',
                'option' => array('values' => array(""))
            ]
        );
    }
}
