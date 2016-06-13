<?php

class ItemManager08 extends AItemManager
{

  private $item_formats;

  public fucntion initialize()
  {
    $item_formats_array = extractItemFormats($this->format['svg']);
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

               $ls_item_formats[$item_format['id']][$ls_item_format['id']] = $ls_item_format;
             }
          }
          if ($item_format['type'] === Item\PageNumberItem::TYPE_NAME) {
              self::setPageNumberUniqueId($item_format);
          }

          $item_formats[$item_format['id']] = $item_format;
      }

      return array(
                'layout' => $item_formats,
                'list' => $ls_item_formats
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
}