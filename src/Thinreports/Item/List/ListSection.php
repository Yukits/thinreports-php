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
    //この仕組自体を変えないと。。。描画に支障がでるかもしれない
    //同じidを用いて、同ページ扱いで作成は可能か？idはインスタンスが違うのでokだが。。
    //描画の仕様がどうなっているのか不明
    $item = $this->layout->createItem($this->parent, $id);
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

  public function getItems()
  {
    return $this->items;
  }

}
