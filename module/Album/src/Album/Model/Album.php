<?php

namespace Album\Model;
// 13
class Album {

  public $id;
  public $artist;
  public $title;

  // 14
  public function exchangeArray($data) {
    $this->id = (!empty($data['id'])) ? $data['id'] : null;
    $this->artist = (!empty($data['artist'])) ? $data['artist'] : null;
    $this->title = (!empty($data['title'])) ? $data['title'] : null;
  }

}
