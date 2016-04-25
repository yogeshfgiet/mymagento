<?php
class Excellence_Colorswatch_Block_Adminhtml_Colorswatch extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_colorswatch';
    $this->_blockGroup = 'colorswatch';
    $this->_headerText = Mage::helper('colorswatch')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('colorswatch')->__('Add Item');
    parent::__construct();
    $this->setTemplate('colorswatch/colorswatch.phtml');
  }
}