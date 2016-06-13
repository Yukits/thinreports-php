<?php

class TLFParser
{

  const COMPATIBLE_VERSION_RANGE_START = '>= 0.8.2';
  const COMPATIBLE_VERSION_RANGE_END   = '< 1.0.0';

  static public function getItemManager($tlf_file)
  {
    $format = json_decode($tlf_file, true);
    if (!self::isCompatible($format['version'])) {
        $rules = array(
            self::COMPATIBLE_VERSION_RANGE_START,
            self::COMPATIBLE_VERSION_RANGE_END
        );
        throw new Exception\IncompatibleLayout($format['version'], $rules);
    }

    if(!version_compare($format['version'], '0.9.0', '>=')){
      return new ItemManagr09($format);
    }else{
      return new ItemManager08($format);
    }  
  }


  /**
   * @access private
   *
   * @param string $file_content
   * @return array
   * @throws Exception\IncompatibleLayout
   */
  static public function parse($file_content)
  {


      // $format = json_decode($file_content, true);
      //

      //
      // $item_formats_array = self::extractItemFormats($format['svg']);
      // self::cleanFormat($format);
      //
      // return array(
      //     'format' => $format,
      //     'item_formats' => $item_formats_array['layout']
      //     'ls_item_formats' => $tem_formats_array['list']
      // );
  }

  /**
   * @access private
   *
   * @param string $layout_format
   * @return array
   */
  static public function extractItemFormats($layout_format)
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
  static public function cleanFormat(&$format)
  {
      $format['svg'] = preg_replace('/<!\-\-.*?\-\->/', '', $format['svg']);
      unset($format['state']);
  }

  /**
   * @access private
   *
   * @param string $layout_version
   * @return boolean
   */
  static public function isCompatible($layout_version)
  {
      $rules = array(
          self::COMPATIBLE_VERSION_RANGE_START,
          self::COMPATIBLE_VERSION_RANGE_END
      );

      foreach ($rules as $rule) {
          list($operator, $version) = explode(' ', $rule);

          if (!version_compare($layout_version, $version, $operator)) {
              return false;
          }
      }
      return true;
  }

  /**
   * @access private
   *
   * @param array $item_format
   */
  static public function setPageNumberUniqueId(array &$item_format)
  {
      if (empty($item_format['id'])) {
          $item_format['id'] = Item\PageNumberItem::generateUniqueId();
      }
  }
}
