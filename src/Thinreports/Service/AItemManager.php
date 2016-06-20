<?php

namespace Thinreports\Service;

use GuzzleHttp\Promise\Tests\Thing1;
use Thinreports\ReportInterface;

abstract class AItemManager
{
  protected $format;//tlfファイルをjson形式にdecodeしたもの
  protected $item_formats;//itemのformatのarray

  public function __construct($format, $item_formats)
  {
      $this->format = $format;
      $this->item_formats = $item_formats;
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

  public function getFormat()
  {
    return $this->format;
  }

  public function getItemFormats()
  {
      return $this->item_formats;
  }

  abstract public function createItem(ReportInterface\iParent $owner, $id);
  abstract public function getTLFVersion();
  abstract public function getPaperType();
  abstract public function getOrientation();
  abstract public function getTitle();
  abstract public function getPageSize();

}
