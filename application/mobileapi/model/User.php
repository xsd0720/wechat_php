<?php
namespace app\mobileapi\model;

use think\Model;

/**
* 
*/
class User extends Model
{
	public function profile()
	{
		
		return $this->hasOne('Profile');
	}

	public function  checkExist($username)
	{
		$data = parent::where('username', $username)->count();
		return $data;
	}
	public function  checkMobileExist($mobile)
	{
		$data = parent::where('mobile', $mobile)->count();
		return $data;
	}

	public function  login($username, $password)
	{
		$map = array();
		$map['mobile'] = $username;
		$user = $this->get($map);

		if ($user) {
			if (think_ucenter_md5($password, config('UC_AUTH_KEY')) === $user->password) {
				$this->updateLogin($user->uid);
				return 1;
			}
			return 0;
		}
	}

	public function updateLogin($uid)
	{
		$data = array();
		$data['uid'] = $uid;
		$data['last_login_time'] = time();
		$data['last_login_ip'] = get_client_ip();
		$this->update($data);

	}


	
}
