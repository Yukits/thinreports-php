<?php

abstract class AItemManager
{
  protected $format;//tlfファイルをjson形式にdecodeしたもの
  protected $item_formats;//itemのformatのarray

  public __construct($format)
  {
      $this->format = $format;
  }
  /**
   * @access private
   *
   * @param string $id
   * @return boolean
   */
  public function hasItem($id)
  {
      return array_key_exists($id, $this->item_formats);
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

    $item_format = $this->item_formats[$id];

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

  public function getFormat()
  {
    return $this->format;
  }

  public function getItemFormats()
  {
      return $this->item_formats;
  }

  abstract public function getTLFVersion();
  abstract public function getPaperType();
  abstract public function getOrientation();
  abstract public function getTitle();
  abstract public function getFilename();
  abstract public function getPageSize();

}
