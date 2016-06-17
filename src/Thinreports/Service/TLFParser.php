<?php

namespace Thinreports\Service;

use Thinreports\Exception;

class TLFParser
{

  const COMPATIBLE_VERSION_RANGE_START = '>= 0.8.2';
  const COMPATIBLE_VERSION_RANGE_END   = '< 1.0.0';

  static public function getItemManager($tlf_file_content)
  {
    $format = json_decode($tlf_file_content, true);
    if (!self::isCompatible($format['version'])) {
        $rules = array(
            self::COMPATIBLE_VERSION_RANGE_START,
            self::COMPATIBLE_VERSION_RANGE_END
        );
        throw new Exception\IncompatibleLayout($format['version'], $rules);
    }

    if(!version_compare($format['version'], '0.9.0', '>=')){
      return new ItemManager09($format);
    }else{
//      return new ItemManager08($format);
        return new Exception\IncompatibleLayout($format['version'], "Please use layout ver 0.9.x");
    }
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
}
