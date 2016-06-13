<?php

abstract class AItemManager
{
  protected $format;//tlfファイルをjson形式にdecodeしたもの
  protected $item_formats;//itemのformatのarray

  public __construct($format)
  {
      $this->format = $format;
  }

  public fuction createItem()
  {

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
