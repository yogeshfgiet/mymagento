<?php

class Excellence_Colorswatch_Model_Observer {
    /*
     * saveImages() runs on event catalog_entity_attribute_save_after, It creats a directory in media/colorswatch/product_id/img
     * it update the image also
     */

    function saveImages(Varien_Event_Observer $event) {
        $file = new Varien_Io_File();
        $path = Mage::getBaseDir();
        $attributeId = (int) $event->getData('event')->getDataObject()->getAttributeId();
        $this->insertAttributeDesignSettings($attributeId);
        $model = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $options = $model->getSource()->getAllOptions(FALSE);
        $allowedExtentions = array('png', 'jpeg', 'gif', 'jpg');
        foreach ($options as $value) {
            $val = (string) $value['value'];
            $file_tmp = $_FILES[$val]['tmp_name'];
            $name = $_FILES[$val]['name'];
            $type = pathinfo($name, PATHINFO_EXTENSION);
            $fullPath = $path . DS . 'media' . DS . 'colorswatch' . DS . $attributeId . DS;
            if (!in_array($type, $allowedExtentions) && !empty($name)) {
                $error = (string) Mage::app()->getConfig()->getNode('global/messages/error/invalid_file');
                Mage::getSingleton('core/session')->addError($error);
            } else if (!empty($name)) {
                $fullPath = $path . DS . 'media' . DS . 'colorswatch' . DS . $attributeId . DS . $value['value'] . DS;
                //unlink($fullPath.'img');
                $file->rmdir($fullPath);
                if (!is_dir($fullPath)) {
                    if (!$file->mkdir($fullPath, 0777, true)) {
                        $error = (string) Mage::app()->getConfig()->getNode('global/messages/error/permissions');
                        Mage::getSingleton('core/session')->addError($error);
                    }
                }
                $fullPath = $fullPath . 'img';
                if (!move_uploaded_file($file_tmp, $fullPath)) {
                    $error = (string) Mage::app()->getConfig()->getNode('global/messages/error/file');
                    Mage::getSingleton('core/session')->addError($error);
                }
            }
        }
    }

    function insertAttributeDesignSettings($attributeId) {
        $boxActiveBorder = Mage::app()->getRequest()->getParam('boxActiveBorder');
        $boxActiveBackground = Mage::app()->getRequest()->getParam('boxActiveBackground');
        $boxInactiveBorder = Mage::app()->getRequest()->getParam('boxInactiveBorder');
        $boxInactiveBackground = Mage::app()->getRequest()->getParam('boxInactiveBackground');
        $boxHeight = Mage::app()->getRequest()->getParam('boxHeight');
        $boxStyle = Mage::app()->getRequest()->getParam('boxStyle');
        $data = array(
            'attribute_id' => $attributeId,
            'box_active_border' => $boxActiveBorder,
            'box_active_background' => $boxActiveBackground,
            'box_inactive_border' => $boxInactiveBorder,
            'box_inactive_background' => $boxInactiveBackground,
            'height' => $boxHeight,
            'box_style' => $boxStyle
        );
        $model = Mage::getModel('colorswatch/design')->getCollection()->addFieldToFilter('attribute_id', $attributeId)->getFirstItem();
        $id = $model->getData('attribute_design_settings_id');
        
        print_r(  $id);
        if (empty($model->getData())) {
            $model = Mage::getModel('colorswatch/design');
            $model->setData($data);
            try {
                $model->save();
            } catch (Exception $ex) {
                Mage::getSingleton('core/session')->addError($ex->getMessage());
            }
        } else {
            $model = Mage::getModel('colorswatch/design')->load($id)->addData($data);
            try {
                $model->setId($id)->save();
            } catch (Exception $ex) {
                Mage::getSingleton('core/session')->addError($ex->getMessage());
            }            
        }
    }

}
