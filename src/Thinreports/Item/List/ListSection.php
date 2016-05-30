<?php

namespace Thinreports\Item\List;

use Thinreports\Item;

class ListSection
{
  private $items = array();
  private $parent;

  public function __construct(ListItem $parent)
  {
    $this->parent = $parent;
  }

  public function item($id)
  {
    if(array_key_exists($id, $this->items)) {
      return $this->items[$id];
    }

    //このidによってcreateItemできるが、どのrowに何をいれるのかをidで行うためには、
    //idはrowごとに一意的になるように変更しなければならない。
    $item = $this->layout->createItem($parent->parent, $id);
    $this->items[$id] = $item;

    return $item;
  }

  /**
   * @param string $id
   * @param mixed $value
   * @throws Exception\StandardException
   */
  public function setItemValue($id, $value)
  {
    $item = $this->item($id);

    if (!$item->isTypeOf('block')) {
        throw new Exception\StandardException('Unedtiable Item', $id);
    }
    $item->setValue($value);
  }

  /**
   * @param array $values
   */
  public function setItemValues(array $values)
  {
      foreach ($values as $id => $value) {
          $this->setItemValue($id, $value);
      }
  }

}
