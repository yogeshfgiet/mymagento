<?php

class Excellence_Colorswatch_Model_Mysql4_Design extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the colorswatch_id refers to the key field in your database table.
        $this->_init('colorswatch/design', 'attribute_design_settings_id');
    }
}
