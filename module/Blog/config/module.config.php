<?php

// Filename: /module/Blog/config/module.config.php
// 97
return array(
  
  'service_manager' => array(
    // 120
    'invokables' => array(
      // 127
      'Blog\Service\PostServiceInterface' => 'Blog\Service\PostService'
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
