<?php

// Filename: /module/Blog/src/Blog/Factory/ListControllerFactory.php

namespace Blog\Factory;

use Blog\Controller\ListController;
use Zend\ServiceManager\FactoryInterface; // 123
use Zend\ServiceManager\ServiceLocatorInterface;

class ListControllerFactory implements FactoryInterface {

  /**
   * Create service
   *
   * @param ServiceLocatorInterface $serviceLocator
   *
   * @return mixed
   */
  // 124
  public function createService(ServiceLocatorInterface $serviceLocator) {
    $realServiceLocator = $serviceLocator->getServiceLocator(); // 125
    $postService = $realServiceLocator
            ->get('Blog\Service\PostServiceInterface'); // 126

    return new ListController($postService);
  }

}
