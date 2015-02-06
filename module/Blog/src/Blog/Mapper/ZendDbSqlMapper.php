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
use Zend\Stdlib\Hydrator\HydratorInterface;

class ZendDbSqlMapper implements PostMapperInterface {

  /**
   * @var \Zend\Db\Adapter\AdapterInterface
   */
  protected $dbAdapter;

  /**
   * @var \Zend\Stdlib\Hydrator\HydratorInterface
   */
  protected $hydrator;

  /**
   * @var \Blog\Model\PostInterface
   */
  protected $postPrototype;

  /**
   * @param AdapterInterface  $dbAdapter
   * @param HydratorInterface $hydrator
   * @param PostInterface    $postPrototype
   */
  // 139
  public function __construct(
    AdapterInterface  $dbAdapter,
    HydratorInterface $hydrator,
    PostInterface     $postPrototype) {
    
    $this->dbAdapter      = $dbAdapter;
    $this->hydrator       = $hydrator;
    $this->postPrototype  = $postPrototype;
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
              $this->hydrator, 
              $this->postPrototype);

      return $resultSet->initialize($result); // 144
    }

    return array(); // 145
  }

}
