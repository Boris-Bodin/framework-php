<?php
namespace OCFram;

abstract class Manager
{
	protected $dao;
	protected $user;
	protected $table;
	protected $class;
	protected $view;

	public function __construct($dao,$user)
	{
		$this->dao = $dao;
		$this->user = $user;
	}
	
	public function save(Entity $item)
	{
		if ($item->isValid())
		{
			$item->isNew() ? $this->add($item) : $this->modify($item);
		}
		else
		{
			throw new \RuntimeException('l\'item doit être validée pour être enregistrée');
		}
	}
	
	protected function add(Entity $item)
	{
		$this->dao->insert($this->table,$item->deshydrate());
	}

	protected function modify(Entity $item)
	{
		var_dump($item->deshydrate());
		$this->dao->update($this->table,$item->deshydrate(),array('id'=> $item->id()));
	}

	public function count()
	{
		return $this->dao->count($this->table);
	}
	
	public function delete($id)
	{
		$this->dao->delete($this->table,array('id' => (int) $id));
	}
	
	public function getList($debut = -1, $limite = -1)
	{
		if($debut != -1 || $limite != -1)
			$datas = $this->dao->select($this->view,'*',["LIMIT" => [(int) $debut,(int) $limite]]);
		else
			$datas = $this->dao->select($this->view,'*');
		
		foreach($datas as &$data)
		{
			$data = new $this->class($data);
		}

		return $datas;	
	}
	
	public function getUnique($id)
	{
		$data = $this->dao->get($this->view,'*',array('id' =>  (int) $id));
		if ($data)
		{
		  return new $this->class($data);
		}
		
		return null;
	}
}
