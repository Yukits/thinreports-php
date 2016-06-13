<?php

abstract class AItemManager
{



  protected $format;//tlfファイルをjson形式にdecodeしたもの


  abstract protected function getIds();
  abstract public function getItemFormats();
  abstract public function getFormat();
  abstract public function getTLFVersion();
  abstract public function getItemFormats();
  abstract public function getItemFormats();
  abstract public function getPaperType();
  abstract public function getOrientation();
  abstract public function getTitle();
  abstract public function getPageSize();


  public fuction createItem()
  {

  }

}
