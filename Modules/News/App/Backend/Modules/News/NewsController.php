<?php
namespace App\Backend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\NewsComment;
use \Entity\News;
use \FormBuilder\CommentFormBuilder;
use \FormBuilder\NewsFormBuilder;
use \OCFram\FormHandler;

class NewsController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Gestion des news');

    $manager = $this->managers->getManagerOf('News');

    $this->page->addVar('listeNews', $manager->getList());
    $this->page->addVar('nombreNews', $manager->count());
  }
  
  public function executeInsert(HTTPRequest $request)
  {
    $this->processForm($request);

    $this->page->addVar('title', 'Ajout d\'une news');
  }

  public function executeUpdate(HTTPRequest $request)
  {
    $this->processForm($request);

    $this->page->addVar('title', 'Modification d\'une news');
  }
  
  public function executeDelete(HTTPRequest $request)
  {
    $newsId = $request->getData('id');
    
    $this->managers->getManagerOf('News')->delete($newsId);
    $this->managers->getManagerOf('NewsComment')->deleteFromNews($newsId);
    
    $this->app->user()->setFlash('La news a bien été supprimée !');
    
    $this->app->httpResponse()->redirect('../');
  }
  
  public function processForm(HTTPRequest $request)
  {
    if ($request->method() == 'POST')
    {
      $news = new News([
        'auteur' => $request->postData('auteur'),
        'titre' => $request->postData('titre'),
        'contenu' => $request->postData('contenu')
      ]);

      if ($request->getExists('id'))
      {
        $news->setId($request->getData('id'));
      }
    }
    else
    {
      // L'identifiant de la news est transmis si on veut la modifier
      if ($request->getExists('id'))
      {
        $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
      }
      else
      {
        $news = new News;
      }
    }

    $formBuilder = new NewsFormBuilder($news);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new \OCFram\FormHandler($form, $this->managers->getManagerOf('News'), $request);

	if ($formHandler->process())
	{
      $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !');
      $this->app->httpResponse()->redirect($news->isNew() ? '.' : '..');
    }

    $this->page->addVar('form', $form->createView());
  }
  
  public function executeDeleteComment(HTTPRequest $request)
  {
	$manager = $this->managers->getManagerOf('NewsComment');
	$id = $request->getData('id');
    $news = $manager->getUnique($id)->news();
    $manager->delete($id);
    
    $this->app->user()->setFlash('Le commentaire a bien été supprimé !');
    
    $this->app->httpResponse()->redirect('/news/' . $news);
  }
}