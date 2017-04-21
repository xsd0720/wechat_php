<?php
namespace app\mobileapi\controller;

use \app\mobileapi\model\User;


class Account
{
    // public function _construct()
    // {
    //      $this->$constant = new Constant();
    // }

    public function index()
    {
        return "class-account";
    }

    /* 登录 */
    public function login()
    {

        if (!request()->isPost()) {
            return json_encode([
                "return_code" => config("REQUEST_METHOD_POST_NEED")[0],
                "return_message" => config("REQUEST_METHOD_POST_NEED")[1]
            ]);
        }

        if (!input('post.')) {
            return json_encode([
                "return_code" => config("REQUEST_NO_PARAMS")[0],
                "return_message" => config("REQUEST_NO_PARAMS")[1]
            ]);
        }

        $username = input('?post.username') ? input('post.username') : '';
        if (!$username) {
            return json_encode([
                "return_code" => config("USERNAME_INVALID")[0],
                "return_message" => config("USERNAME_INVALID")[1]
            ]);
        }
        $password = input('?post.password') ? input('post.password') : '';
        if (!$password) {
            return json_encode([
                "return_code" => config("PASSWORD_INVALID")[0],
                "return_message" => config("PASSWORD_INVALID")[1]
            ]);
        }

        $user = new User();
        if ($user->login($username, $password)) {

            $user = $user->get(["mobile"=>$username]);
            return json_encode([
                "return_code" => config("REQUEST_SUCCESED")[0],
                "return_message" => config("REQUEST_SUCCESED")[1],
                "mobile"=>$user->mobile,
                "profile" => [
                    "mobile" => $user->mobile,
//                "head_pic_url" => $user->head_pic_url,
                    "username" => $user->wxnumber,
                    "myqrcode" => $user->profile->myqrcode,
                    "personSig" =>$user->profile->personsign
                ]
            ]);
        }
        return json_encode([
            "return_code" => config("LOGIN_ERROR")[0],
            "return_message" => config("LOGIN_ERROR")[1]
        ]);
    }

    /* 登出 */
    public function logout()
    {
        return json_encode([
            "return_code" => config("REQUEST_SUCCESED")[0],
            "return_message" => config("REQUEST_SUCCESED")[1]
        ]);
    }

    /* 注册 */
    public function register()
    {
        if (!request()->isPost()) {
            return json_encode([
                "return_code" => config("REQUEST_METHOD_POST_NEED")[0],
                "return_message" => config("REQUEST_METHOD_POST_NEED")[1]
            ]);
        }

        if (!input('post.')) {
            return json_encode([
                "return_code" => config("REQUEST_NO_PARAMS")[0],
                "return_message" => config("REQUEST_NO_PARAMS")[1]
            ]);
        }
        $mobile = input('?post.mobile') ? input('post.mobile') : '';
        if (!$mobile) {
            return json_encode([
                "return_code" => config("MOBILE_LOST")[0],
                "return_message" => config("MOBILE_LOST")[1]
            ]);
        }
        $username = input('?post.username') ? input('post.username') : '';
        if (!$username) {
            return json_encode([
                "return_code" => config("USERNAME_INVALID")[0],
                "return_message" => config("USERNAME_INVALID")[1]
            ]);
        }
        $password = input('?post.password') ? input('post.password') : '';
        if (!$password) {
            return json_encode([
                "return_code" => config("PASSWORD_INVALID")[0],
                "return_message" => config("PASSWORD_INVALID")[1]
            ]);
        }

        $wxnumber = input('?post.wechatnumber') ? input('post.wechatnumber') : '';

        $user = new User();
        $user = $user->get(["mobile"=>$mobile]);
//        if ($user->checkExist($username)) {
//            return json_encode([
//                "return_code" => config("USERNAME_EXISTED")[0],
//                "return_message" => config("USERNAME_EXISTED")[1]
//            ]);
//        }
        $user->wxnumber = $wxnumber;
        $user->username = $username;

        $user->password = think_ucenter_md5($password, config('UC_AUTH_KEY'));

        if ($user->save()) {
            return json_encode([
                "return_code" => config("REQUEST_SUCCESED")[0],
                "return_message" => config("REQUEST_SUCCESED")[1]
            ]);
        } else {
            return json_encode([
                "return_code" => config("REGISTER_ERROR")[0],
                "return_message" => config("REGISTER_ERROR")[1]
            ]);
        }


    }

    /* 更新个人信息 */
    public function update()
    {

        return "update";
    }

    /* 获取个人信息 */
    public function profile()
    {

        if (!request()->isPost()) {
            return json_encode([
                "return_code" => config("REQUEST_METHOD_POST_NEED")[0],
                "return_message" => config("REQUEST_METHOD_POST_NEED")[1]
            ]);
        }

        if (!input('post.')) {
            return json_encode([
                "return_code" => config("REQUEST_NO_PARAMS")[0],
                "return_message" => config("REQUEST_NO_PARAMS")[1]
            ]);
        }
        $mobile = input('?post.mobile') ? input('post.mobile') : '';
        if (!$mobile) {
            return json_encode([
                "return_code" => config("MOBILE_LOST")[0],
                "return_message" => config("MOBILE_LOST")[1]
            ]);
        }
        $user = new User();
        $user = $user->get(["mobile"=>$mobile]);
        return json_encode([
            "return_code" => config("REQUEST_SUCCESED")[0],
            "return_message" => config("REQUEST_SUCCESED")[1],
            "mobile"=>$user->mobile,
            "profile" => [
                "mobile" => $user->mobile,
//                "head_pic_url" => $user->head_pic_url,
                "username" => $user->wxnumber,
                "myqrcode" => $user->profile->myqrcode,
                "personSig" =>$user->profile->personsign,
            ]
        ]);
    }

    /* 修改密码 */
    public function update_pwd()
    {
        return "update_pwd";
    }

    /* 更改头像 */
    public function changeheadpic()
    {
        $file = request()->file('photos');
        $error = $file->getInfo()['error'];
//        $error = $_FILES['file']['error']; // 如果$_FILES['file']['error']>0,表示文件上传失败
        if($error){
            return json_encode([
                "return_code" => config("REQUEST_NO_PARAMS")[0],
                "return_message" => config("REQUEST_NO_PARAMS")[1]
            ]);
        }

        $filename = $file->getInfo()['name'];
        $dir = 'upload';
        if (!is_dir($dir))
        {
            mkdir($dir, 0777, true);
        }
        $info = $file->move($dir);
        $imagePath = str_replace('\\', '/', $info->getPathname());
        return json_encode([

            "return_code" => config("REQUEST_SUCCESED")[0],
            "return_message" => config("REQUEST_SUCCESED")[1],
            "imagepath" => $imagePath
        ]);
    }

    public function requestsns()
    {
        if (!request()->isPost()) {
            return json_encode([
                "return_code" => config("REQUEST_METHOD_POST_NEED")[0],
                "return_message" => config("REQUEST_METHOD_POST_NEED")[1]
            ]);
        }

        if (!input('post.')) {
            return json_encode([
                "return_code" => config("REQUEST_NO_PARAMS")[0],
                "return_message" => config("REQUEST_NO_PARAMS")[1]
            ]);
        }

        $mobile = input('?post.mobile') ? input('post.mobile') : '';
        if (!$mobile) {
            return json_encode([
                "return_code" => config("MOBILE_INVALID")[0],
                "return_message" => config("MOBILE_INVALID")[1]
            ]);
        }

        $user = new User();
        if ($user->checkMobileExist($mobile)) {
            return json_encode([
                "return_code" => config("USERNAME_EXISTED")[0],
                "return_message" => config("USERNAME_EXISTED")[1]
            ]);
        }

        $user->mobile = $mobile;
        $user->save();
        $opcode = get_code(6, 1);
        $user->profile()->save(['vcode' => $opcode]);
        return json_encode([
            "return_code" => config("REQUEST_SUCCESED")[0],
            "return_message" => config("REQUEST_SUCCESED")[1]
        ]);


    }

    public function checkvcode()
    {
        if (!request()->isPost()) {
            return json_encode([
                "return_code" => config("REQUEST_METHOD_POST_NEED")[0],
                "return_message" => config("REQUEST_METHOD_POST_NEED")[1]
            ]);
        }

        if (!input('post.')) {
            return json_encode([
                "return_code" => config("REQUEST_NO_PARAMS")[0],
                "return_message" => config("REQUEST_NO_PARAMS")[1]
            ]);
        }
        $mobile = input('?post.mobile') ? input('post.mobile') : '';
        if (!$mobile) {
            return json_encode([
                "return_code" => config("MOBILE_INVALID")[0],
                "return_message" => config("MOBILE_INVALID")[1]
            ]);
        }
        $vcode = input('?post.vcode') ? input('post.vcode') : '';
        if (!$mobile) {
            return json_encode([
                "return_code" => config("MOBILE_INVALID")[0],
                "return_message" => config("MOBILE_INVALID")[1]
            ]);
        }


        $user = new User();
        $user = $user::get(["mobile" => $mobile]);
        if ($user->profile->vcode === $vcode) {
            return json_encode([
                "return_code" => config("REQUEST_SUCCESED")[0],
                "return_message" => config("REQUEST_SUCCESED")[1]
            ]);
        }
        return json_encode([
            "return_code" => config("VCODE_ERROR")[0],
            "return_message" => config("VCODE_ERROR")[1]
        ]);

    }

    public function toukan()
    {
        if (!request()->isPost()) {
            return json_encode([
                "return_code" => config("REQUEST_METHOD_POST_NEED")[0],
                "return_message" => config("REQUEST_METHOD_POST_NEED")[1]
            ]);
        }

        if (!input('post.')) {
            return json_encode([
                "return_code" => config("REQUEST_NO_PARAMS")[0],
                "return_message" => config("REQUEST_NO_PARAMS")[1]
            ]);
        }
        $mobile = input('?post.mobile') ? input('post.mobile') : '';
        if (!$mobile) {
            return json_encode([
                "return_code" => config("MOBILE_INVALID")[0],
                "return_message" => config("MOBILE_INVALID")[1]
            ]);
        }
        $user = new User();
        $user = $user->get(["mobile" => $mobile]);
        return json_encode([
            "return_code" => config("REQUEST_SUCCESED")[0],
            "return_message" => config("REQUEST_SUCCESED")[1],
            "data" => $user->profile->vcode
        ]);
    }
}
