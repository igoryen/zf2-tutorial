<?php

// Filename: /module/Blog/src/Blog/Factory/WriteControllerFactory.php
// 121
namespace Blog\Factory;

use Blog\Controller\WriteController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class WriteControllerFactory implements FactoryInterface {

  public function createService(ServiceLocatorInterface $serviceLocator) {
    $realServiceLocator = $serviceLocator->getServiceLocator();
    $postService = $realServiceLocator->get('Blog\Service\PostServiceInterface');
    $postInsertForm = $realServiceLocator
            ->get('FormElementManager') // 168
            ->get('Blog\Form\PostForm');

    // 167
    return new WriteController(
            $postService,
            $postInsertForm
    );
  }

}
