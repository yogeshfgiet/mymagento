<?php
class Excellence_Colorswatch_Block_Adminhtml_Tabs extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs
{
   private $parent;
   protected function _prepareLayout() {
        //get all existing tabs
        $this->parent = parent::_prepareLayout();
        //add new tab
        $this->addTab('', array(
                     'label'     => Mage::helper('catalog')->__('Attribute Images'),
                     'content'   => $this->getLayout()
             ->createBlock('colorswatch/adminhtml_tabs_tabid')->toHtml(),
	     
        ));
        return $this->parent;
    }
}
