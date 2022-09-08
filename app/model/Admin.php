<?php

namespace app\model;

class Admin extends BaseModel
{
    protected $schema = [
        'id'           => 'int',
        'account'      => 'string',
        'password'     => 'string',
        'is_active'    => 'int',
        'created_time' => 'int',
        'deleted_time' => 'int'
    ];

    // 通过account获取用户信息
    public function getInfoByAccount(string $account): array
    {
        $admin = $this->field('account, password, is_active as isActive')->where('account', '=', $account)->find();
        if (is_null($admin)) {
            return [];
        }
        return $admin->toArray();
    }

    // 新增管理员
    public function add(string $account, string $password): bool
    {
        return $this->save([
            'account'      => $account,
            'password'     => $password,
            'created_time' => time()
        ]);
    }

}