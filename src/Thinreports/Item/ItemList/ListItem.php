<?php

namespace Thinreports\Item\ItemList;

use Thinreports\Page\Page;
use Thinreports\Item\AbstractItem;

class ListItem  extends AbstractItem
{
  const TYPE_NAME = 's-list';

  private $auto_page_break;

  private $header;
  private $rows = array();
  private $page_footer;
  private $footer;

  //footerとheaderは自動改ページのときには変化しないが、addPageのときには初期化される。
  //page_footerはどちらも変化する

  public function __construct(Page $parent, array $format)
  {
    parent::__construct($parent, $format);
    $this->auto_page_break = $format['auto_page_break'];
  }

  public function addRow()
  {
      $new_row = new ListSection($this, $this->format['detail']);
      $this->rows[] = $new_row;

      return $new_row;
  }

  public function addHeader()
  {
    if($this->header === null){
      $this->header = new ListSection($this, $this->format['header']);
    }

    return $this->header;
  }

  public function isAutoPageBreak()
  {
    return $this->auto_page_break;
  }

  public function getRows()
  {
    return $this->rows;
  }

  public function getBounds()
  {
    $bounds = array(
      'detail-x'
    );

    if($this->format['footer-enabled']){

    }
    if($this->format['page-footer-enabled']){

    }
    if($this->format['header-enabled']){

    }
    return;
  }
}
