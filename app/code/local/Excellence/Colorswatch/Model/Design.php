<?php

class Excellence_Colorswatch_Model_Design extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('colorswatch/design');
    }
}
