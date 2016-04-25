<?php
class Excellence_Colorswatch_Block_Colorswatch extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getColorswatch()     
     { 
      
         
        if (!$this->hasData('colorswatch')) {
            $this->setData('colorswatch', Mage::registry('colorswatch'));
        }
    
        return $this->getData('colorswatch');
        
    }
}