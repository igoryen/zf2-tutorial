<?php

// Filename: /module/Blog/src/Blog/Mapper/ZendDbSqlMapper.php

namespace Blog\Mapper;

use Blog\Mapper\PostMapperInterface;
use Blog\Model\PostInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;

class ZendDbSqlMapper implements PostMapperInterface {

  /**
   * @var \Zend\Db\Adapter\AdapterInterface
   */
  protected $dbAdapter;

  /**
   * @param AdapterInterface  $dbAdapter
   */
  // 139
  public function __construct(AdapterInterface $dbAdapter) {
    $this->dbAdapter = $dbAdapter;
  }

  /**
   * @param int|string $id
   *
   * @return PostInterface
   * @throws \InvalidArgumentException
   */
  public function find($id) {
    
  }

  /**
   * @return array|PostInterface[]
   */
  public function findAll() {
    $sql = new Sql($this->dbAdapter);
    $select = $sql->select('posts');

    $stmt = $sql->prepareStatementForSqlObject($select);
    $result = $stmt->execute();

    //return $result;
    //\Zend\Debug\Debug::dump($result);die(); // 141
    
    
    //TTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTT
    /*
    if ($result instanceof ResultInterface && $result->isQueryResult()) {
      $resultSet = new ResultSet();

      \Zend\Debug\Debug::dump($resultSet->initialize($result)); // 142
      die();
    }

    die("no data");
    */
    //LLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLL
    
    if ($result instanceof ResultInterface && $result->isQueryResult()) {
      // 143
      $resultSet = new HydratingResultSet(
              new \Zend\Stdlib\Hydrator\ClassMethods(), 
              new \Blog\Model\Post()
              );

      return $resultSet->initialize($result); // 144
    }

    return array(); // 145
  }

}
