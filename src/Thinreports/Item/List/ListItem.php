<?php

namespace Thinreports\Item\List;

use Thinreports\Page\Page;
use Thinreports\Item\AbstractItem;
use Thinreports\Interface\iParent;

class ListItem  extends AbstractItem
{
  const TYPE_NAME = 's-list';

  private $item_formats = array();

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


  /**
   * @access private
   *
   * @param ListSection $owner
   * @param string $id
   * @return Item\AbstractItem
   * @throws Exception\StandardException
   */
  public function createItem(ListSection $owner, $id)
  {
      if (!$this->hasItem($id)) {
          throw new Exception\StandardException('Item Not Found', $id);
      }

      $item_format = $this->item_formats[$id];

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
          default:
              return new Item\BasicItem($owner, $item_format);
              break;
      }
  }
}
