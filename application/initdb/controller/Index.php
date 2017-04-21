<?php
namespace app\initdb\controller;
use \app\initdb\model\initdb;


class Index
{
    public function index()
    {
    	$i = new initdb();


    	if (!$i-> initdb()) {
    		return "success";
    	}
    	return "failure";
    }
}
