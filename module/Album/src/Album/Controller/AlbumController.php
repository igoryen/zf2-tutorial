<?php

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\Album;
use Album\Form\AlbumForm;

class AlbumController extends AbstractActionController {
  
  protected $albumTable;
  
  // GET: /album
  public function indexAction() {
    // 32
    return new ViewModel(array(
      'albums' => $this->getAlbumTable()->fetchAll(),
    ));
  }

  // GET: /album/add
  public function addAction() {
    $form = new AlbumForm(); // 56
    $form->get('submit')->setValue('Add'); // 57

    $request = $this->getRequest();
    if ($request->isPost()) { // 58
      $album = new Album();
      $form->setInputFilter($album->getInputFilter()); // 59
      $form->setData($request->getPost()); // 60

      if ($form->isValid()) { // 61
        $album->exchangeArray($form->getData()); // 62
        $this->getAlbumTable()->saveAlbum($album); // 63

        // Redirect to list of albums
        return $this->redirect()->toRoute('album'); // 64
      }
    }
    return array('form' => $form); // 65
  }
  // GET: /album/edit
  public function editAction() {
    
  }
   //GET: /album/delete
  public function deleteAction() {
    
  }
  
   // 31
  public function getAlbumTable() {
    if (!$this->albumTable) {
      $sm = $this->getServiceLocator();
      $this->albumTable = $sm->get('Album\Model\AlbumTable');
    }
    return $this->albumTable;
  }

}
