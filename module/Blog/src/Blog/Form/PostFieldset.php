<?php

// Filename: /module/Blog/src/Blog/Form/PostFieldset.php

namespace Blog\Form;

use Zend\Form\Fieldset; // 161

class PostFieldset extends Fieldset {

  public function __construct($name = null, $options = array()) { // 174
    
    parent::__construct($name, $options); // 173
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
