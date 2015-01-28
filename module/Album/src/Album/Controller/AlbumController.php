<?php

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AlbumController extends AbstractActionController {
  
  protected $albumTable;
  
  // GET: /album
  public function indexAction() {
    
  }
  // GET: /album/add
  public function addAction() {
    
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
