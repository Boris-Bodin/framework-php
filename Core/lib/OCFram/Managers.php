<?php
namespace OCFram;

class Managers
{
  protected $api = null;
  protected $dao = null;
  protected $app = null;
  protected $managers = [];

  public function __construct($api, $dao, $app)
  {
    $this->api = $api;
    $this->dao = $dao;
    $this->app = $app;
  }

  public function getManagerOf($module)
  {
    if (!is_string($module) || empty($module))
    {
      throw new \InvalidArgumentException('Le module spécifié est invalide');
    }

    if (!isset($this->managers[$module]))
    {
      $manager = '\\Model\\'.$module.'Manager'.$this->api;

      $this->managers[$module] = new $manager($this->dao,$this->app->user());
    }

    return $this->managers[$module];
  }
}