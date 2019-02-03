<?php

namespace matacms\cache\caching;

use yii\caching\DbDependency;

class MataLastUpdatedTimestampDependency extends DbDependency
{

    public $sql = "select `Value` from mata_keyvalue where `Key` = :key";
    public $params = [':key' => \matacms\cache\Module::KV_LAST_MATA_UPDATE_KEY];
    public $reusable = true;

}
