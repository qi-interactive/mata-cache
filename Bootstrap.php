<?php 

namespace matacms\cache;

use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\db\BaseActiveRecord;
use mata\keyvalue\models\KeyValue;

class Bootstrap implements BootstrapInterface {

	public function bootstrap($app) {

		if ($this->canRun($app) == false)
			return;

		Event::on(BaseActiveRecord::className(), BaseActiveRecord::EVENT_AFTER_INSERT, function($event) {
			$this->updateLastModifiedDate($event->sender);
		});

		Event::on(BaseActiveRecord::className(), BaseActiveRecord::EVENT_AFTER_UPDATE, function($event) {
			$this->updateLastModifiedDate($event->sender);
		});

		Event::on(BaseActiveRecord::className(), BaseActiveRecord::EVENT_AFTER_DELETE, function($event) {
			$this->updateLastModifiedDate($event->sender);
		});
	}

	private function updateLastModifiedDate(BaseActiveRecord $model) {

		if (is_a($model, "mata\keyvalue\models\KeyValue"))
			return;
		
		$kv = KeyValue::find(\matacms\cache\Module::KV_LAST_MATA_UPDATE_KEY)->one();

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