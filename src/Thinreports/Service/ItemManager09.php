<?php

namespace Thinreports\Service;

use Thinreports\Item;
use Thinreports\Item\ItemList;
use Thinreports\Exception;
use Thinreports\ReportInterface;

class ItemManager09 extends AItemManager
{
  public function __construct($format, $item_formats, $static)
  {
    parent::__construct($format, $item_formats, $static);
  }

  public static function newInstance($format)
  {
    $tmp = self::extractItemFormats($format);
    return new self($format, $tmp[0], $tmp[1]);
  }

  public static function extractItemFormats($format)
  {

      $item_formats = array();
      $static_images = array();
      $static_texts = array();
      $static_lines = array();
      $static_ellipses = array();
      $static_rects = array();

      foreach ($format['items'] as $i) {
          $item_format = $i;

          switch ($item_format['type']){
              case 'page-number':
                  self::setPageNumberUniqueId($item_format);
                  break;
              case 'image':
                  $static_images[] = $item_format;
                  break;
              case 'text':
                  $static_texts[] = $item_format;
                  break;
              case 'line':
                  $static_lines[] = $item_format;
                  break;
              case 'ellipse':
                  $static_ellipses[] = $item_format;
                  break;
              case 'rect':
                  $static_rects[] = $item_format;
                  break;
              default:
                  $item_formats[$item_format['id']] = $item_format;
                  break;
          }
      }

      $statics = array(
        "text" => $static_texts,
          "image" => $static_images,
          "line" => $static_lines,
          "ellipse" => $static_ellipses,
          "rect" => $static_rects
      );
      return array($item_formats, $statics);
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
  public function createItem(ReportInterface\iParent $owner, $id)
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
      case 'text-block':
        return new Item\TextBlockItem($owner, $item_format);
        break;
      case 'image-block':
        return new Item\ImageBlockItem($owner, $item_format);
        break;
      case 'page-number':
        return new Item\PageNumberItem($owner, $item_format);
        break;
      case 'list':
        if($owner->isPage()){
          return new Item\ItemList\ListItem($owner, $item_format);
        }
        break;
      default:
        return new Item\BasicItem($owner, $item_format);
        break;
    }
  }

  public function getTLFVersion()
  {
    return $this->format['version'];
  }
  public function getPaperType()
  {
    return $this->format['report']['paper-type'];
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
    return $this->getPaperType();
  }

    public function getMargin(){
        return $this->format['report']['margin'];
    }

    public function createLayoutIdentifier(){
        return md5((string)$this->format);
    }
}
