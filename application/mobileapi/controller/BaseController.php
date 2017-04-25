<?php
/**
 * Created by PhpStorm.
 * User: xwmedia01
 * Date: 2017/4/24
 * Time: 下午3:07
 */
namespace app\mobileapi\controller;
use think\Controller;


class BaseController extends Controller {
    public function _initialize() {
        // 登陆检测代码
        if (!request()->isPost()) {
            die(json_encode([
                "return_code" => config("REQUEST_METHOD_POST_NEED")[0],
                "return_message" => config("REQUEST_METHOD_POST_NEED")[1]
            ]));
        }

        if (!input('post.')) {
            die(json_encode([
                "return_code" => config("REQUEST_NO_PARAMS")[0],
                "return_message" => config("REQUEST_NO_PARAMS")[1]
            ]));
        }

    }
}