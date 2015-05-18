<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\cache\caching;

use Yii;
use yii\caching\Dependency;
use mata\keyvalue\models\KeyValue;
use yii\db\Query;

class MataLastUpdatedTimestampDependency extends Dependency {

	private static $lastTimestamp;

    protected function generateDependencyData($cache) {

    	if (self::$lastTimestamp)
    		return self::$lastTimestamp;

    	$query = new Query;
    	$query->select(['Value'])
    	    ->from(KeyValue::tableName())
    	    ->where(['Key' => \matacms\cache\Module::KV_LAST_MATA_UPDATE_KEY]);

    	if (KeyValue::getDb()->enableQueryCache) {
    	    KeyValue::getDb()->enableQueryCache = false;
    	    $value = $query->createCommand(KeyValue::getDb())->queryScalar();
    	    KeyValue::getDb()->enableQueryCache = true;
    	} else {
    	    $value = $query->createCommand(KeyValue::getDb())->queryScalar();
    	}

    	self::$lastTimestamp = $value > 0 ? $value : 1;

        return self::$lastTimestamp;
    }
}
