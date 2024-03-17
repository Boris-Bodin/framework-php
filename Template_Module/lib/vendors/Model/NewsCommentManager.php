<?php
namespace Model;

use \OCFram\Manager;
use \Entity\NewsComment;

abstract class NewsCommentManager  extends Manager
{
	public function __construct($dao,$user)
	{
        parent::__construct($dao,$user);
		$this->table = 'news_comments';
		$this->view = 'news_comments';
		$this->class = '\Entity\NewsComment';
	}
	
	abstract public function getListOf($news);
	  
    abstract public function deleteFromNews($news);
}