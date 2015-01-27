<?php

namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;

class AlbumTable {

  protected $tableGateway; // 15

  public function __construct(TableGateway $tableGateway) {
    $this->tableGateway = $tableGateway; // 16
  }

  // 17
  // 18
  public function fetchAll() {
    $resultSet = $this->tableGateway->select();
    return $resultSet;
  }

  // 19
  public function getAlbum($id) {
    $id = (int) $id;
    $rowset = $this->tableGateway->select(array('id' => $id));
    $row = $rowset->current();
    if (!$row) {
      throw new \Exception("Could not find row $id");
    }
    return $row;
  }

  // 20
  public function saveAlbum(Album $album) {
    $data = array(
      'artist' => $album->artist,
      'title' => $album->title,
    );

    $id = (int) $album->id;
    if ($id == 0) {
      $this->tableGateway->insert($data);
    }
    else {
      if ($this->getAlbum($id)) {
        $this->tableGateway->update($data, array('id' => $id));
      }
      else {
        throw new \Exception('Album id does not exist');
      }
    }
  }

  // 21
  public function deleteAlbum($id) {
    $this->tableGateway->delete(array('id' => (int) $id));
  }

}
