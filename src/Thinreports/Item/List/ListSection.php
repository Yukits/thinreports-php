<?php

namespace Thinreports\Item\List;

use Thinreports\Item;

class ListSection implements iParent
{
  private $item_formats;
  private $items = array();
  private $parent;

  public function __construct(ListItem $parent, $format)
  {
    $this->item_formats = $format;
    $this->parent = $parent;
  }

  public function item($id)
  {
    if(array_key_exists($id, $this->items)) {
      return $this->items[$id];
    }

    // $item = $this->parent->createItem($this, $id);
    // $this->items[$id] = $item;

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

  public function getItems()
  {
    return $this->items;
  }


  public function isCountable()
  {
    return false;
  }

  public function isPage()
  {
    return false;
  }

  public fuction getItemFormats()
  {
    return $this->item_formats;
  }

}
