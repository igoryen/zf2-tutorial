<?php

// Filename: /module/Blog/config/module.config.php
// 97
return array(
  // 137
  'db' => array(
    'driver' => 'Pdo',
    'username' => 'root', //edit this
    'password' => '1111', //edit this
    'dsn' => 'mysql:dbname=blog;host=localhost',
    'driver_options' => array(
      \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
    )
  ),
  
//  'service_manager' => array(
//    // 120
//    //'invokables' => array(
//      // 127
//      //'Blog\Service\PostServiceInterface' => 'Blog\Service\PostService'
//    'factories' => array(
//      // 135
//      //'Blog\Service\PostServiceInterface' => 'Blog\Factory\PostServiceFactory,'
//    )
//  ),
  
  'service_manager' => array(
    'factories' => array(
      // 140
      'Blog\Mapper\PostMapperInterface'   => 'Blog\Factory\ZendDbSqlMapperFactory',
      'Blog\Service\PostServiceInterface' => 'Blog\Factory\PostServiceFactory',
      // 138
      'Zend\Db\Adapter\Adapter'           => 'Zend\Db\Adapter\AdapterServiceFactory',
    )
  ),
  
  // 
  'view_manager' => array(
    'template_path_stack' => array(
      __DIR__ . '/../view',
    ),
  ),
  
  'controllers' => array(
    // 120
    //'invokables' => array(
    //  'Blog\Controller\List' => 'Blog\Controller\ListController' // 106
    //)
    // 121
    'factories' => array(
      'Blog\Controller\List' => 'Blog\Factory\ListControllerFactory' // 122
    )
  ),
  
  // 99
  'router' => array(
    // 100
    'routes' => array(
      // 101
      'post' => array(
        // 102
        'type' => 'literal',
        // 103
        'options' => array(
          // 104
          'route' => '/blog',
          // 105
          'defaults' => array(
            'controller' => 'Blog\Controller\List',
            'action' => 'index',
          )
        )
      )
    )
  )
);
