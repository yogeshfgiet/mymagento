<?php

class Excellence_Colorswatch_IndexController extends Mage_Core_Controller_Front_Action {
    /*
     * isdir action called by colorswatch.js's hasImage, this function checks image directory exists or not 
     */
    function isdirAction() {   
		
     
        $dir = $this->getRequest()->getParam('dir');      
        $options=$this->getRequest()->getParam('opts');
        $imageDirectory=Mage::getBaseDir().DS.'media'.DS.'colorswatch'.DS.$dir;
        foreach($options as $option){
            if(is_dir($imageDirectory.DS.$option['id'])){
                $directoryExist=array('yes'=>1);
                break;
            }
            else{
                $directoryExist=array('yes'=>0);
            }
        }
        
        return $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($directoryExist));        
    }
    /*
     * deleteimage called when ever user click on cross icon which appears when user hover on the image in admin panel. 
     * This function delete the image and when all images are deleted then it will delete the whole directory also.  
     */
    function deleteimageAction(){
        $path = Mage::getBaseDir();
        $attributeId=$this->getRequest()->getPost('aId');        
        $optionId=$this->getRequest()->getPost('oId');        
        $imageDirectory= $path . DS.'media'.DS.'colorswatch'. DS . $attributeId . DS;
        $imageDirectory=$imageDirectory.DS.$optionId.DS.'img';
        $isDeleted=array('yes'=>1);
        if(!unlink($imageDirectory)){
            $isDeleted['yes']=0;
        }
        $optionDriectory=$path . DS.'media'.DS.'colorswatch'. DS . $attributeId . DS.$optionId;
        rmdir($optionDriectory);
        $attributeDirectory=$path . DS.'media'.DS.'colorswatch'. DS . $attributeId . DS;
        rmdir($attributeDirectory);
        return $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($isDeleted));
    }
    function insertAction(){
        $model=Mage::getModel('colorswatch/design');
        $model->setAttributeId(133);
        $model->save();
    }
    
}
