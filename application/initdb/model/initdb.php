<?php
namespace app\initdb\model;
use \think\Model;
use \think\Db;
/**
* 
*/


// CREATE TABLE IF NOT EXISTS User(uid integer  PRIMARY KEY NOT NULL auto_increment,username varchar(255),password varchar(255),wxnumber varchar(255))

class initdb
{
	
	function initdb()
	{

		// Db::execute("CREATE DATABASE IF NOT EXISTS bdm269871325_db");

		$sql = "
			CREATE TABLE IF NOT EXISTS User
			(
				uid integer PRIMARY KEY NOT NULL AUTO_INCREMENT,
				mobile   varchar(255),
				username varchar(255),
				password varchar(255),
				wxnumber varchar(255),
				last_login_time varchar(255),
				last_login_ip varchar(255)
			)
		";

		$sql2 = "
			CREATE TABLE IF NOT EXISTS Profile
			(
				user_id integer,
				sex  int,
				myqrcode varchar(255),
				area varchar(255),
				personsign varchar(255),
				vcode  varchar(255),
				head_pic_url varchar(255)
			)
		";

		$fkSql = "
			ALTER TABLE Profile  ADD CONSTRAINT  user_uid_fk FOREIGN KEY (user_id) REFERENCES User (uid)
		";

		Db::execute($sql);
		Db::execute($sql2);
		Db::execute($fkSql);

		return 0;
	}
}

// CREATE TABLE Persons(uid int,username varchar(255),password varchar(255),wxnumber varchar(255),myqrcode varchar(255),sex  int,area varchar(255),personsign varchar(255));