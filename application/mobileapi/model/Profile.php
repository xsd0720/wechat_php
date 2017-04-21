<?php
namespace app\mobileapi\model;

use think\Model;

/**
* 
*/
class Profile extends Model
{
	
	// function __construct(argument)
	// {
	// 	# code..
	// }

	/* 我们就可以根据档案资料来获取用户模型的信息 */
	 public function user()
	 {
	 	return $this->belongsTo('User');
	 }
}