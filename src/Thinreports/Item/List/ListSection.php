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
}
