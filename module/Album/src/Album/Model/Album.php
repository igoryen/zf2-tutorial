<?php

namespace Album\Model;

use Zend\InputFilter\InputFilter; // 90
use Zend\InputFilter\InputFilterAwareInterface; // 44
use Zend\InputFilter\InputFilterInterface;

// 13
class Album implements InputFilterAwareInterface { // 44

  public $id;
  public $artist;
  public $title;
  protected $inputFilter;  

  // 14
  public function exchangeArray($data) {
    $this->id = (!empty($data['id'])) ? $data['id'] : null;
    $this->artist = (!empty($data['artist'])) ? $data['artist'] : null;
    $this->title = (!empty($data['title'])) ? $data['title'] : null;
  }
  
  public function getArrayCopy() {
    return get_object_vars($this);
  }

  // 45
  public function setInputFilter(InputFilterInterface $inputFilter) {
    throw new \Exception("Not used"); // 47
  }

  // 46
  public function getInputFilter() {
    if (!$this->inputFilter) {
      $inputFilter = new InputFilter(); // 48

      // 49 
      
      // 50
      $inputFilter->add(array(
        'name' => 'id',
        'required' => true,
        'filters' => array(
          array('name' => 'Int'),
        ),
      ));

      // 51
      $inputFilter->add(array(
        'name' => 'artist',
        'required' => true, // 52
        'filters' => array(
          array('name' => 'StripTags'), // 54
          array('name' => 'StringTrim'), // 55
        ),
        'validators' => array(
          array(
            'name' => 'StringLength', // 53
            'options' => array(
              'encoding' => 'UTF-8',
              'min' => 1,
              'max' => 100,
            ),
          ),
        ),
      ));

      $inputFilter->add(array(
        'name' => 'title',
        'required' => true,
        'filters' => array(
          array('name' => 'StripTags'),
          array('name' => 'StringTrim'),
        ),
        'validators' => array(
          array(
            'name' => 'StringLength',
            'options' => array(
              'encoding' => 'UTF-8',
              'min' => 1,
              'max' => 100,
            ),
          ),
        ),
      ));

      $this->inputFilter = $inputFilter;
    } // if(!$this->inputFilter)

    return $this->inputFilter;
  }

}
