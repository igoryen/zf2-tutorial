<?php
// 1

namespace Album;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface {
  // 2
  public function getAutoloaderConfig() {
    // 4
    return array(
        'Zend\Loader\ClassMapAutoloader' => array(
            __DIR__ . '/autoload_classmap.php',
        ),
        'Zend\Loader\StandardAutoloader' => array(
            'namespaces' => array(
                __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
            ),
        ),
    );
  }
  
  // 3
  public function getConfig() {
    return include __DIR__ . '/config/module.config.php';
  }
  
  // 22
  public function getServiceConfig() {
    // 23
    return array(
      'factories' => array(
        'Album\Model\AlbumTable' => function($sm) {
          $tableGateway = $sm->get('AlbumTableGateway'); // 24
          $table = new AlbumTable($tableGateway); // 25
          return $table;
        },
        'AlbumTableGateway' => function ($sm) {
          $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter'); // 26
          $resultSetPrototype = new ResultSet();
          $resultSetPrototype->setArrayObjectPrototype(new Album());
          return new TableGateway('album', $dbAdapter, null, $resultSetPrototype); // 27
        },
      ),
    );
  }

}
