<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('attribute_design_settings')};
CREATE TABLE {$this->getTable('attribute_design_settings')} (
  `attribute_design_settings_id` int(11) unsigned NOT NULL auto_increment,
  `attribute_id` smallint(5) unsigned NOT NULL,
  `box_active_border` varchar(200) NOT NULL default '#000',
  `box_active_background` varchar(200) NOT NULL default '',
  `box_inactive_border` varchar(200) NOT NULL default '#000',
  `box_inactive_background` varchar(200) NOT NULL default '',  
  `height` int(11) unsigned NOT NULL default 50,
  `box_style` varchar(200) NOT NULL,
  PRIMARY KEY (`attribute_design_settings_id`),
  foreign key(`attribute_id`) REFERENCES catalog_eav_attribute(`attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 
