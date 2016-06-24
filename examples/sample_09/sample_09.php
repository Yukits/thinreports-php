<?php

require __DIR__ . '/../../vendor/autoload.php';

date_default_timezone_set('Asia/Tokyo');

use Thinreports\Report;

$report = new Report(__DIR__ . '/sample_09.tlf');

$page = $report->addPage();

$page->item('text')->setValue('land-text');
$page->item('text#1')->setValue('land-text#1');

$page->item('image')->setSource()->setValue(__DIR__ . '/ocean.JPG');

////header
//$default = $page->item('default')->addHeader();
//
//$default->item('text')->setValue('header-text');
//$default->item('text#1')->setValue('header-text#1');
//
////footer
//$default = $page->item('default')->addFooter();
//
//$default->item('text')->setValue('footer-text');
//$default->item('text#1')->setValue('footer-text#1');
//
////page-footer
//$default = $page->item('default')->addPageFooter();
//
//$default->item('text')->setValue('page-footer-text');
//$default->item('text#1')->setValue('page-footer-text#1');

//row
$rows = array(
    array(
        "text" => "row1-text",
        "text#1" => "row1-text#1",
    ),
    array(
        "text" => "row2-text",
        "text#1" => "row2-text#1",
    ),
    array(
        "text" => "row3-text",
        "text#1" => "row3-text#1",
    )
);

foreach($rows as $row){
    $default = $page->item('default')->addRow();
    $default->item('text')->setValue($row['text']);
    $default->item('text#1')->setValue($row['text#1']);
}

$report->generate(__DIR__ . '/sample_09.pdf');


