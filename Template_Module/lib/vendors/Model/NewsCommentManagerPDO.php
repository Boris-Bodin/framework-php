<?php
namespace Model;

use \Entity\NewsComment;

class NewsCommentManagerPDO extends NewsCommentManager
{
	
	public function getListOf($news)
	{
		if (!is_numeric($news) && !ctype_digit($news))
		{
			throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un nombre entier valide');
		}

		$datas = $this->dao->select($this->table,'*',array('news' => $news,'ORDER' => 'id ASC'));
		
		foreach($datas as &$data)
		{
			$data = new $this->class($data);
			$data->setDate(new \DateTime($data->date()));
		}
		return $datas;
	}
	
	public function deleteFromNews($news)
	{
		$this->dao->delete($this->table,array('news' => (int) $news));
	}
}