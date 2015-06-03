<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\cache;

use mata\base\Module as BaseModule;

class Module extends BaseModule {

	const KV_LAST_MATA_UPDATE_KEY = "matacms\cache::last-mata-update";

	public function getNavigation() {
		return null;
	}
	
	public function canShowInNavigation() {
		return false;
	}
}
