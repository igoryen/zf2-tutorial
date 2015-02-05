<?php

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel; // 88
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
    $id = (int) $this->params()->fromRoute('id', 0); // 73
    if (!$id) { // 74
      return $this->redirect()->toRoute('album', array(
                'action' => 'add'
      ));
    }

    // Get the Album with the specified id.  An exception is thrown
    // if it cannot be found, in which case go to the index page.
    try {
      $album = $this->getAlbumTable()->getAlbum($id); // 75
    } catch (\Exception $ex) { // 76
      return $this->redirect()->toRoute('album', array(
                'action' => 'index'
      ));
    }

    $form = new AlbumForm();
    $form->bind($album); // 77
    $form->get('submit')->setAttribute('value', 'Edit'); // 89

    $request = $this->getRequest();
    if ($request->isPost()) {
      $form->setInputFilter($album->getInputFilter());
      $form->setData($request->getPost());

      if ($form->isValid()) {
        $this->getAlbumTable()->saveAlbum($album); // 78

        // Redirect to list of albums
        return $this->redirect()->toRoute('album');
      }
    }

    return array(
      'id' => $id,
      'form' => $form,
    );
  }

  //GET: /album/delete
  public function deleteAction() {
    $id = (int) $this->params()->fromRoute('id', 0); // 73
    if (!$id) {
      return $this->redirect()->toRoute('album');
    }

    $request = $this->getRequest();
    if ($request->isPost()) { // 81
      $del = $request->getPost('del', 'No');

      if ($del == 'Yes') {
        $id = (int) $request->getPost('id');
        $this->getAlbumTable()->deleteAlbum($id); // 82
      }

      // Redirect to list of albums
      return $this->redirect()->toRoute('album'); // 83
    }

    // 84
    return array(
      'id' => $id,
      'album' => $this->getAlbumTable()->getAlbum($id) // 85
    );
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
