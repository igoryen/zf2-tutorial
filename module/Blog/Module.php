<?php

// Filename: /module/Blog/Module.php
// 1

namespace Blog;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

class Module implements AutoloaderProviderInterface,
                        ConfigProviderInterface {

  // 107
  public function getAutoloaderConfig() {
    return array(
      // 108
      'Zend\Loader\StandardAutoloader' => array(
        'namespaces' => array(
          // Autoload all classes from namespace 'Blog' from '/module/Blog/src/Blog'
          __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
        )
      )
    );
  }

  // 95
  public function getConfig() {
    //return array(); // 96
    return include __DIR__ . '/config/module.config.php'; // 98
  }

}
