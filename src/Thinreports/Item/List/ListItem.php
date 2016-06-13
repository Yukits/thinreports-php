<?php

namespace Thinreports\Item\List;

use Thinreports\Page\Page;
use Thinreports\Item\AbstractItem;
use Thinreports\Interface\iParent;

class ListItem  extends AbstractItem implements iParent
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
      $new_row = new ListSection($this);
      $this->rows[] = $new_row;

      return $new_row;
  }

  //いらないかも
  public function addHeader()
  {
    $this->header = new ListSection($this);

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
    )

    if($this->format['footer-enabled']){

    }
    if($this->format['page-footer-enabled']){

    }
    if($this->format['header-enabled']){

    }
    return
  }

  public function isCountable()
  {
    return false;
  }

  public function isPage()
  {
    return false;
  }
}
