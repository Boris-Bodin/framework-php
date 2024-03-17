<?php
namespace Model;

use \OCFram\Manager;

abstract class NewsManager extends Manager
{
	public function __construct($dao,$user)
	{
        parent::__construct($dao,$user);
		$this->table = 'news';
		$this->view = 'news';
		$this->class = '\Entity\News';
	}
}