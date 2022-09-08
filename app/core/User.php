<?php

namespace app\core;

use app\model\Admin;

class User
{
    // 检查用户是否存在
    // 0 用户不存在  1用户存在但是未激活 2用户存在 3密码错误
    public function checkAdmin(string $account, string $passwd): int
    {
        $adminModel = new Admin();
        $admin = $adminModel->getInfoByAccount($account);

        if (empty($admin)) {
            return 0;
        }

        if (md5($passwd) == $admin['password']) {
            return $admin['isActive'] == 0 ? 1 : 2;
        } else {
            return 3;
        }

    }

    // 新增管理员
    public function addAdmin(string $account, string $passwd): bool
    {
        $adminModel = new Admin();
        return $adminModel->add($account, md5($passwd));
    }
}