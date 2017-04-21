<?php
//配置文件
return [
	
	/* public */
	"REQUEST_METHOD_POST_NEED" => ["2", "post method need"],
	"REQUEST_METHOD_GET_NEED" => ["3", "get method need"],
	"REQUEST_NO_PARAMS" => ["4", "request params error"],


	/* account */
	"REQUEST_SUCCESED" 	=> ["0", "OK"],
	"USERNAME_INVALID"  => ["101", "用户名无效"],
	"USERNAME_EXISTED" 	=> ["102", "用户名已存在"],
	"PASSWORD_SHORT"    => ["103", "密码太短"],
	"PASSWORD_INVALID"  => ["104", "密码无效"],
	"LOGIN_ERROR"       => ["105", "登录失败"],
	"REGISTER_ERROR"       => ["106", "注册失败"],
	"MOBILE_INVALID"   => ["107", "手机号无效"],
	"VCODE_ERROR"      => ["108", "验证码错误"],
    "MOBILE_LOST"      => ["109", "手机号丢失"],
    "FILE_UPLOAD_ERROR" => ["110", "文件上传失败"]
];