<?php

// Filename: /module/Blog/src/Blog/Form/PostFieldset.php

namespace Blog\Form;

use Blog\Model\Post;
use Zend\Form\Fieldset; // 161
use Zend\Stdlib\Hydrator\ClassMethods;

class PostFieldset extends Fieldset {

  public function __construct($name = null, $options = array()) { // 174
    
    parent::__construct($name, $options); // 173
    
    $this->setHydrator(new ClassMethods(false)); // 
    $this->setObject(new Post());
    
    // 162
    $this->add(array(
      'type' => 'hidden',
      'name' => 'id'
    ));

    $this->add(array(
      'type' => 'text',
      'name' => 'text',
      'options' => array(
        'label' => 'The Text'
      )
    ));

    $this->add(array(
      'type' => 'text',
      'name' => 'title',
      'options' => array(
        'label' => 'Blog Title'
      )
    ));
  }

}
