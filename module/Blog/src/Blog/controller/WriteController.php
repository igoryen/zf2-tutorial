<?php

// Filename: /module/Blog/src/Blog/Controller/WriteController.php

namespace Blog\Controller;

use Blog\Service\PostServiceInterface;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel; // 88

class WriteController extends AbstractActionController {

  protected $postService;
  protected $postForm;

  public function __construct(
    PostServiceInterface $postService, // 169
          FormInterface $postForm
  ) {
    $this->postService = $postService;
    $this->postForm = $postForm;
  }

  public function addAction() {

    $request = $this->getRequest(); // 178

    if ($request->isPost()) { // 179
      $this->postForm->setData($request->getPost()); // 180

      if ($this->postForm->isValid()) { // 181
        try {
          //\Zend\Debug\Debug::dump($this->postForm->getData());die(); // 198
          $this->postService->savePost($this->postForm->getData()); // 182
          return $this->redirect()->toRoute('blog'); // 183
        } catch (\Exception $e) {
          // Some DB Error happened, log it and let the user know
        }
      }
    }
    // 175
    return new ViewModel(array(
      'form' => $this->postForm
    ));
  }

}
