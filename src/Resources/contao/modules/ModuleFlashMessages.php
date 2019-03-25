<?php 

namespace DieSchittigs;

use Contao\Flash;

class ModuleFlashMessages extends \Module {
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_flash_messages';

	/**
	 * Display a wildcard in the back end
	 *
	 * @return string
	 */
	public function generate() {
		if (TL_MODE == 'BE') {
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['flash_messages'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
        }
		return parent::generate();
	}

	/**
	 * Generate the module
	 */
	protected function compile() {
		/**
		 * Set template vars
        */
        
        $flashMessages = Flash::load();

        $ids = [];
		$encIds = [];
		
		if($flashMessages) {
			foreach($flashMessages as $flash){
				if(!$flash->autoDismiss) continue;
				$ids[] = $flash->id;
				$encIds[] = "\"$flash->id\"";
			}
		}

		$this->Template->flashMessages = $flashMessages;
		$this->Template->ids = $ids;
		$this->Template->encIds = $encIds;
	}
}