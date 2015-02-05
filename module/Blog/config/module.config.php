<?php

// Filename: /module/Blog/config/module.config.php
// 97
return array(
  // 
  'view_manager' => array(
    'template_path_stack' => array(
      __DIR__ . '/../view',
    ),
  ),
  
  'controllers' => array(
    'invokables' => array(
      'Blog\Controller\List' => 'Blog\Controller\ListController' // 106
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
