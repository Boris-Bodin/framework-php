<?php
namespace OCFram;

class Router
{
  protected $routes = [];

  const NO_ROUTE = 1;

  public function addRoute(Route $route)
  {
    if (!in_array($route, $this->routes))
    {
      $this->routes[] = $route;
    }
  }

  public function automateRoute($url)
  {
	$tmp = explode("/",$url);
	$module = $tmp[1];
	$action = 'index';
	$varsNames = array();
//	$listVars = array();
	if(isset($tmp[2]) && $tmp[2] != '')
	  $action = explode("?",$tmp[2])[0];
/*	for($i = 3 ; $i < count($tmp) ;$i++)
	  if(isset($tmp[$i]) && $tmp[$i] != ''){
		$vars = explode("#",$tmp[$i]);
		var_dump($tmp[$i]);
		$varsNames[] = $vars[0];
		$listVars[$vars[0]] = $vars[1];
	  }
		$varsNames[] =  intval($tmp[$i],10);*/
    $route = new Route($url, $module, $action, $varsNames);
    //$route->setVars($listVars);
    return $route;
  }
  
  public function getRoute($url)
  {
    foreach ($this->routes as $route)
    {
      if (($varsValues = $route->match($url)) !== false)
      {
        if ($route->hasVars())
        {
          $varsNames = $route->varsNames();
          $listVars = [];
          foreach ($varsValues as $key => $match)
          {
            if ($key !== 0)
            {
              $listVars[$varsNames[$key - 1]] = $match;
            }
          }
          $route->setVars($listVars);
        }

        return $route;
      }
    }
    throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
  }
}