<?php
namespace App\Frontend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\NewsComment;
use \FormBuilder\CommentFormBuilder;
use \OCFram\FormHandler;

class NewsController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $nombreNews = $this->app->config()->get('nombre_news');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');
    
    $this->page->addVar('title', 'Liste des '.$nombreNews.' dernières news');
    
    $manager = $this->managers->getManagerOf('News');
    
    $listeNews = $manager->getList(0, $nombreNews);
    
    foreach ($listeNews as $news)
    {
      if (strlen($news->contenu()) > $nombreCaracteres)
      {
        $debut = substr($news->contenu(), 0, $nombreCaracteres);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
        
        $news->setContenu($debut);
      }
    }
    
    $this->page->addVar('listeNews', $listeNews);
  }
  
  public function executeShow(HTTPRequest $request)
  {
    $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
    
    if (empty($news))
    {
      $this->app->httpResponse()->redirect404();
    }
    
    $this->page->addVar('title', $news->titre());
    $this->page->addVar('news', $news); 
	$this->page->addVar('comments', $this->managers->getManagerOf('NewsComment')->getListOf($news->id()));
  }
  
  public function executeInsertComment(HTTPRequest $request)
  {
    if ($request->method() == 'POST')
    {
      $comment = new NewsComment([
        'news' => $request->getData('news'),
        'auteur' => $request->postData('auteur'),
        'contenu' => $request->postData('contenu')
      ]);
    }
    else
    {
      $comment = new NewsComment;
    }

    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();

    $form = $formBuilder->form();

    if ($request->method() == 'POST' && $form->isValid())
    {
      $this->managers->getManagerOf('NewsComment')->save($comment);
      $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
      $this->app->httpResponse()->redirect('/news/'.$request->getData('news').'');
    }

    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'un commentaire');
  }
}