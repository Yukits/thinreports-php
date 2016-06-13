<?php

class ItemManager09 extends AItemManager
{
  public __construct($format)
  {
    parent::__construct($format);
    $this->extractItemFormats($format)
  }

  /**
   * @access private
   *
   * @param string $layout_format
   * @return array
   */
  public function extractItemFormats($format)
  {

      $item_formats = array();

      foreach ($format['items'] as $i) {
          $item_format = json_decode($i, true);

          if ($item_format['type'] === Item\PageNumberItem::TYPE_NAME) {
              self::setPageNumberUniqueId($item_format);
          }

          $item_formats[$item_format['id']] = $item_format;
      }

      return $item_formats;
  }

  /**
   * @access private
   *
   * @param array $item_format
   */
  public function setPageNumberUniqueId(array &$item_format)
  {
      if (empty($item_format['id'])) {
          $item_format['id'] = Item\PageNumberItem::generateUniqueId();
      }
  }

  /**
   * @access private
   *
   * @param iParent $owner
   * @param string $id
   * @return Item\AbstractItem
   * @throws Exception\StandardException
   */
  public fuction createItem(iParent $owner, $id)
  {
    if (!$this->hasItem($id)) {
      throw new Exception\StandardException('Item Not Found', $id);
    }

    if(!$owner->isPage())//list section
    {
      $item_format = $owner->getItemFormats()[$id];
    }else{
      $item_format = $this->item_formats[$id];
    }

    switch ($item_format['type']) {
      case 's-tblock':
        return new Item\TextBlockItem($owner, $item_format);
        break;
      case 's-iblock':
        return new Item\ImageBlockItem($owner, $item_format);
        break;
      case 's-pageno':
        return new Item\PageNumberItem($owner, $item_format);
        break;
      case 's-list':
        if($owner->isPage()){
          return new Item\List\ListItem($owner, $item_format);
        }
        break;
      default:
        return new Item\BasicItem($owner, $item_format);
        break;
    }
  }

  public fuction getListItemFormats(){
    return $this->ls_item_formats;
  }

  public function getTLFVersion()
  {
    return $this->format['version'];
  }
  public function getPaperType()
  {
    return $this->format['report']['paper-type'];//json_decode必要か？
  }
  public function getOrientation()
  {
    return $this->format['report']['orientation'];
  }
  public function getTitle()
  {
    return $this->format['title'];
  }

  public function getPageSize()
  {
    // if ($this->getPaperType() === 'user') {
    //     $page = $this->format['config']['page'];
    //     return array($page['width'], $page['height']);
    // } else {
    //     return null;
    // }
    return null;
  }
}
