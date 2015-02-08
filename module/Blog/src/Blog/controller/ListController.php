<?php

// Filename: /module/Blog/src/Blog/Controller/ListController.php

namespace Blog\Controller;

use Blog\Service\PostServiceInterface;
use Zend\Mvc\Controller\AbstractActionController; // 109
use Zend\View\Model\ViewModel; // 129

class ListController extends AbstractActionController {
  
  /**
   * @var \Blog\Service\PostServiceInterface
   */
  protected $postService;
  
  // 115
  public function __construct(PostServiceInterface $postService) { // 119
    $this->postService = $postService;
  }
  
  public function indexAction() {
    // 128
    //echo "Hi!!!";
    return new ViewModel(array(
      // 130
      'posts' => $this->postService->findAllPosts()
    ));
  }
  
  public function detailAction() {
    $id = $this->params()->fromRoute('id');

    try {
      $post = $this->postService->findPost($id); // 159
    } catch (\InvalidArgumentException $ex) {
      return $this->redirect()->toRoute('blog'); // 160
    }

    return new ViewModel(array(
      'post' => $post
    ));
  }

}
