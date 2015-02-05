<?php

// Filename: /module/Blog/src/Blog/Controller/ListController.php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController; // 109

class ListController extends AbstractActionController {

  /**
   * @var \Blog\Service\PostServiceInterface
   */
  protected $postService;
  
  // 115
  public function __construct(PostServiceInterface $postService) { // 119
    $this->postService = $postService;
  }

}
