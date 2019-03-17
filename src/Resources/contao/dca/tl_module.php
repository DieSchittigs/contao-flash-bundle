<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['flash_messages']    = '{title_legend},name,headline,type;{config_legend},flash_namespace;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

// Add fields to tl_module
$GLOBALS['TL_DCA']['tl_module']['fields']['flash_namespace'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_flash']['namespace'],
    'exclude'                 => true,
    'search'                  => false,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'alias', 'doNotCopy'=>false, 'unique'=>false, 'maxlength'=>32, 'tl_class'=>'w50 clr'),
    'sql'                     => "varchar(32) BINARY NOT NULL default ''"
];