<?php

namespace Thinreports\Service;

use Thinreports\Item;
use Thinreports\Exception;

class ItemManager08 extends AItemManager
{
  // private $ls_item_formats;

  public function __construct($format)
  {
//    parent::__construct($format);
//    initialize();
  }

  public function initialize()
  {
    $item_formats_array = extractItemFormats($this->format['svg']);
    $this->item_formats = $item_formats_array['layout'];
    // $this->ls_item_formats = $item_formats_array['list'];
    cleanFormat($this->format);
  }

  /**
   * @access private
   *
   * @param string $layout_format
   * @return array
   */
  public function extractItemFormats($layout_format)
  {
      preg_match_all('/<!--SHAPE(.*?)SHAPE-->/',
          $layout_format, $matched_items, PREG_SET_ORDER);

      $item_formats = array();
      $ls_item_formats = array();

      foreach ($matched_items as $matched_item) {
          $item_format_json = $matched_item[1];
          $item_format = json_decode($item_format_json, true);

          if ($item_format['type'] === 's-list') {
            preg_match_all('/<!---SHAPE(.*?)SHAPE--->/',
             $item_format['detail']['svg']['content'], $matched_ls_items, PREG_SET_ORDER);

             foreach ($matched_ls_items as $matched_ls_item) {
               $ls_item_format_json = $matched_ls_item[1];
               $ls_item_format = json_decode($ls_item_format_json, true);

              //  $ls_item_formats[$item_format['id']][$ls_item_format['id']] = $ls_item_format;
             }
          }
          if ($item_format['type'] === Item\PageNumberItem::TYPE_NAME) {
              self::setPageNumberUniqueId($item_format);
          }

          $item_formats[$item_format['id']] = $item_format;
      }

      return array(
                'layout' => $item_formats,
                // 'list' => $ls_item_formats
              );
  }

  /**
   * @access private
   *
   * @param array $format
   */
  public function cleanFormat(&$format)
  {
      $format['svg'] = preg_replace('/<!\-\-.*?\-\->/', '', $format['svg']);
      unset($format['state']);
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
  public function createItem(iParent $owner, $id)
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
          return new Item\ItemList\ListItem($owner, $item_format);
        }
        break;
      default:
        return new Item\BasicItem($owner, $item_format);
        break;
    }
  }

  public function getListItemFormats(){
    return $this->ls_item_formats;
  }

  public function getTLFVersion()
  {
    return $this->format['version'];
  }
  public function getPaperType()
  {
    return $this->format['config']['page']['paper-type'];
  }
  public function getOrientation()
  {
    return $this->format['config']['page']['orientation'];
  }
  public function getTitle()
  {
    return $this->format['config']['title'];
  }

  public function getPageSize()
  {
    if ($this->getPaperType() === 'user') {
        $page = $this->format['config']['page'];
        return array($page['width'], $page['height']);
    } else {
        return null;
    }
  }
}
