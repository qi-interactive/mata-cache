<?php

/*
 * This file is part of the mata project.
 *
 * (c) mata project <http://github.com/mata/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace matacms\cache;

use mata\base\Module as BaseModule;

/**
 * This is the main module class for the Yii2-user.
 *
 * @property array $modelMap
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Module extends BaseModule {

	const KV_LAST_MATA_UPDATE_KEY = "matacms\cache::last-mata-update";

	public function getNavigation() {
		return null;
	}
	
	public function canShowInNavigation() {
		return false;
	}
}