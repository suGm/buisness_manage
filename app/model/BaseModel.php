<?php

namespace app\model;

use think\Model;
use think\model\concern\SoftDelete;

class BaseModel extends Model
{
    use SoftDelete;
    protected $deleteTime = 'deleted_time';
    protected $defaultSoftDelete = 0;
}