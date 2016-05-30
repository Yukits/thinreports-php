<?php

namespace Thinreports\Item\List;

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

  public function __construct(Page $parent, array $format, $auto_page_break = false)
  {
    parent::__construct($parent, $format);
    $this->auto_page_break = $auto_page_break;
  }

  public function addRow(ListSection $new_row)
  {
    $this->rows += $new_row;
  }

  public function setHeader(ListSection $header)
  {
    $this->header = $header;
  }

  public function isAutoPageBreak()
  {
    return $this->auto_page_break;
  }
}
