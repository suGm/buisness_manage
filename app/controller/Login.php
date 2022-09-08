<?php

namespace app\controller;

use app\BaseController;
use app\core\User;
use think\App;
use think\facade\Session;

class Login extends BaseController
{
    protected $needCheckLogin = false;

    public function __construct(App $app)
    {
        parent::__construct($app);
        // 判断用户是否登录或选择退出登录，已登录则跳转admin界面
        if (!empty($this->loginUser) && $this->request->action() != 'loginOut') {
            header('Location:/admin');
            exit();
        }
    }

    // 登录界面
    public function index()
    {
        return view('index');
    }

    // 登录
    public function login()
    {
        $name   = $this->request->post('name', '');
        $passwd = $this->request->post('passwd', '');
        // 防止只输入空格 去除字符串左右两侧的空格
        $name = trim($name);
        // 验证姓名不能为空
        if ($name == '') {
            return json(['code' => 400, 'msg' => '用户名不能为空', 'data' => []]);
        }

        // 验证密码不能为空
        if ($passwd == '') {
            return json(['code' => 400, 'msg' => '密码不能为空', 'data' => []]);
        }

        // 判断管理员是否存在
        $user = new User();
        $checkUser = $user->checkAdmin($name, $passwd);
        if ($checkUser == 0) {
            // 不存在
            return json(['code' => 404, 'msg' => '当前用户不存在，请先进行注册', 'data' => []]);
        } elseif ($checkUser == 1) {
            // 存在 但是未激活
            return json(['code' => 401, 'msg' => '当前用户未激活，请联系管理员激活', 'data' => []]);
        } elseif ($checkUser == 3){
            // 存在 但是密码错误
            return json(['code' => 402, 'msg' => '密码错误', 'data' => []]);
        } else {
            // 存储登录信息
            Session::set('userInfo', json_encode(['account' => $name]));
            return json(['code' => 200, 'msg' => '登录成功', 'data' => []]);
        }
    }

    // 注册
    public function register()
    {
        $account  = $this->request->post('name', '');
        $password = $this->request->post('passwd', '');
        $account  = trim($account);
        // 验证姓名不能为空
        if ($account == '') {
            return json(['code' => 400, 'msg' => '用户名不能为空', 'data' => []]);
        }

        // 验证密码不能为空
        if ($password == '') {
            return json(['code' => 400, 'msg' => '密码不能为空', 'data' => []]);
        }

        // 判断管理员是否存在
        $user = new User();
        $checkUser = $user->checkAdmin($account, $password);
        if ($checkUser != 0) {
            return json(['code' => 400, 'msg' => '当前用户已存在', 'data' => []]);
        }

        if ($user->addAdmin($account, $password)) {
            return json(['code' => 200, 'msg' => '注册成功', 'data' => []]);
        }

        return json(['code' => 500, 'msg' => '注册失败', 'data' => []]);
    }

    // 退出登录
    public function loginOut()
    {
        Session::destroy();
        header('Location:/login');
        exit();
    }
}