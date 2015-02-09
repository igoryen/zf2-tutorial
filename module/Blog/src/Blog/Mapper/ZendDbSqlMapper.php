<?php

// Filename: /module/Blog/src/Blog/Mapper/ZendDbSqlMapper.php

namespace Blog\Mapper;

use Blog\Mapper\PostMapperInterface;
use Blog\Model\PostInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
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

    $sql = new Sql($this->dbAdapter);
    $select = $sql->select('posts');
    $select->where(array('id = ?' => $id)); // 146

    $stmt = $sql->prepareStatementForSqlObject($select);
    $result = $stmt->execute();

    if ($result instanceof ResultInterface 
            && $result->isQueryResult() 
            && $result->getAffectedRows() // 147
        ) {
      
      return $this->hydrator->hydrate(
              $result->current(), 
              $this->postPrototype // 148
              );
    }
    // 149
    throw new \InvalidArgumentException("Blog with given ID:{$id} not found.");
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
  
  /**
   * @param PostInterface $postObject
   *
   * @return PostInterface
   * @throws \Exception
   */
  public function save(PostInterface $postObject) {
    $postData = $this->hydrator->extract($postObject); // 184
    // 185
    unset($postData['id']); // Neither Insert nor Update needs the ID in the array

    if ($postObject->getId()) { // 186
      // ID present, it's an Update
      $action = new Update('posts'); // 187
      $action->set($postData); // 190
      $action->where(array('id = ?' => $postObject->getId()));
    }
    else { // 188
      // ID NOT present, it's an Insert
      $action = new Insert('posts'); // 189
      $action->values($postData); // 191
    }

    $sql = new Sql($this->dbAdapter);
    $stmt = $sql->prepareStatementForSqlObject($action); // 192
    $result = $stmt->execute();

    if ($result instanceof ResultInterface) { // 193
      if ($newId == $result->getGeneratedValue()) { // 194
        // When a value has been generated, set it on the object
        $postObject->setId($newId); // 195
      }

      return $postObject; // 196
    }

    throw new \Exception("Database error");
  }

}
