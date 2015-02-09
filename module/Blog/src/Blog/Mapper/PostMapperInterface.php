<?php

// Filename: /module/Blog/src/Blog/Mapper/PostMapperInterface.php

namespace Blog\Mapper; // 132

use Blog\Model\PostInterface;
// 131
interface PostMapperInterface {

  /**
   * @param int|string $id
   * @return PostInterface
   * @throws \InvalidArgumentException
   */
  public function find($id); // 133

  /**
   * @return array|PostInterface[]
   */
  public function findAll(); // 134

  /**
   * @param PostInterface $postObject
   *
   * @param PostInterface $postObject
   * @return PostInterface
   * @throws \Exception
   */
  public function save(PostInterface $postObject);
}
