<?php
namespace Model;

use \Entity\News;

class NewsManagerPDO extends NewsManager
{
  public function getList($debut = -1, $limite = -1)
  {
	$listeNews = parent::getList($debut,$limite);
    
    foreach ($listeNews as $news)
    {
      $news->setDateAjout(new \DateTime($news->dateAjout()));
      $news->setDateModif(new \DateTime($news->dateModif()));
    }
    
    return $listeNews;
  }
  
  public function getUnique($id)
  {
	$news = parent::getUnique($id);
    
	if($news){
	  $news->setDateAjout(new \DateTime($news->dateAjout()));
      $news->setDateModif(new \DateTime($news->dateModif()));
    }
    return $news;
  }
}