<?php

// Filename: /module/Blog/src/Blog/Form/PostForm.php

namespace Blog\Form;

use Zend\Form\Form; // 165

class PostForm extends Form {

  public function __construct() {
    // 163
    $this->add(array(
      'name' => 'post-fieldset',
      'type' => 'Blog\Form\PostFieldset'
    ));

    // 164
    $this->add(array(
      'type' => 'submit',
      'name' => 'submit',
      'attributes' => array(
        'value' => 'Insert new Post'
      )
    ));
  }

}
