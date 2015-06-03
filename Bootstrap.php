<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\cache;

use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\db\BaseActiveRecord;
use mata\keyvalue\models\KeyValue;
use yii\base\Application;

class Bootstrap implements BootstrapInterface {

	static $shouldUpdate = false;

	public function bootstrap($app) {

		if ($this->canRun($app) == false)
			return;

		Event::on(BaseActiveRecord::className(), BaseActiveRecord::EVENT_AFTER_INSERT, function($event) {
			self::$shouldUpdate = true;
		});

		Event::on(BaseActiveRecord::className(), BaseActiveRecord::EVENT_AFTER_UPDATE, function($event) {
			self::$shouldUpdate = true;
		});

		Event::on(BaseActiveRecord::className(), BaseActiveRecord::EVENT_AFTER_DELETE, function($event) {
			self::$shouldUpdate = true;
		});

		Event::on(Application::className(), Application::EVENT_AFTER_REQUEST, function($event) {
			if (self::$shouldUpdate)
				$this->updateLastModifiedDate();
		});
	}

	private function updateLastModifiedDate() {
		
		$kv = KeyValue::find()->where(["Key" => \matacms\cache\Module::KV_LAST_MATA_UPDATE_KEY])->one();

		if ($kv == null) {
			$kv = new KeyValue();
			$kv->Key = \matacms\cache\Module::KV_LAST_MATA_UPDATE_KEY;
		}

		$kv->Value = time();

		if ($kv->save() == false)
			throw new \yii\web\ServerErrorHttpException($kv->getTopError());

	}

	private function canRun($app) {
		return is_a($app, "yii\console\Application") == false;
	}
}
