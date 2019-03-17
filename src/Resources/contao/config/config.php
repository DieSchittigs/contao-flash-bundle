<?php

/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['miscellaneous']['flash_messages'] = 'DieSchittigs\ModuleFlashMessages';

// Style sheet
if (TL_MODE == 'FE')
{
	$GLOBALS['TL_CSS'][] = 'bundles/contaoflash/style.css|static';
}

// JavaScript
if (TL_MODE == 'FE')
{
	$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/contaoflash/script.js|static';
}
