<?php
namespace OCFram;

class PDOFactory
{
  public static function getMysqlConnexion()
  {
	$db = new Medoo(array(
		'database_type' => 'mysql',
		'database_name' => 'site_domain',
		'server' => 'localhost',
		'username' => 'admin',
		'password' => 'ExN754Aodq',
		 
		'option' => array(
		\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
		)
	));
    return $db;
  }
}