<?php

/*
 * This file is part of the Thinreports PHP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Thinreports\Generator\Renderer;

use Thinreports\Layout;
use Thinreports\Generator\PDF;
use Thinreports\Exception;

/**
 * @access private
 */
class LayoutRenderer extends AbstractRenderer
{
    private $items;

    /**
     * @param PDF\Document $doc
     * @param Layout $layout
     */
    public function __construct(PDF\Document $doc, Layout $layout)
    {
        parent::__construct($doc);
        $this->items = $layout->getStaticItemFormats();
//        $this->items = $this->parse($layout);
    }

    /**
     * @param Layout $layout
     * @return array()
     */
    public function parse(Layout $layout)
    {


//        $svg = preg_replace('<%.+?%>', '', $layout->getSVG());
//
//        $xml = new \SimpleXMLElement($svg);
//        $xml->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');
//        $xml->registerXPathNamespace('xlink', 'http://www.w3.org/1999/xlink');
//
//        $items = array();
//
//        foreach ($xml->g->children() as $element) {
//            $attributes = (array) $element->attributes();
//            $attributes = $attributes['@attributes'];
//
//            switch ($attributes['class']) {
//                case 'text':
//                    $text_lines = array();
//
//                    foreach ($element->text as $text_line) {
//                        $text_lines[] = $text_line;
//                    }
//                    $attributes['content'] = implode("\n", $text_lines);
//                    break;
//                case 'image':
//                    $xlink_attribute = $element->attributes('xlink', true);
//                    $attributes['xlink:href'] = (string) $xlink_attribute['href'];
//                    break;
//            }
//
//            $items[] = $attributes;
//        }
//        return $items;
    }

    public function render()
    {
        foreach ($this->items['text'] as $i){
            $this->renderStaticText($i);
        }
        foreach ($this->items['image'] as $i){
            $this->renderStaticImage($i);
        }
        foreach ($this->items['line'] as $i){
            $this->renderStaticLine($i);
        }
        foreach ($this->items['ellipse'] as $i){
            $this->renderStaticEllipse($i);
        }
        foreach ($this->items['rect'] as $i){
            $this->renderStaticRect($i);
        }
    }

    public function renderStaticText(array $attrs)
    {
        $styles = $this->buildTextStyles($attrs);

        if (array_key_exists('vertical-align', $attrs['style'])) {
            $valign = $attrs['vertical-align'];
        } else {
            $valign = null;
        }
        $styles['valign'] = $this->buildVerticalAlign($valign);

        if (array_key_exists('line-height-ratio', $attrs['style'])
                && $attrs['style']['line-height-ratio'] !== '') {
            $styles['line_height'] = $attrs['style']['line-height-ratio'];
        }

        $text = "";
        foreach ($attrs['texts'] as $line) {
            if($text == ""){
                $text = $text . $line;
            }else{
                $text = $text . "\n" . $line;
            }
        }

        $this->doc->text->drawTextBox(
            $text,
            $attrs['x'],
            $attrs['y'],
            $attrs['width'],
            $attrs['height'],
            $styles
        );
    }

    public function renderStaticRect(array $attrs)
    {
        $styles = $this->buildGraphicStyles($attrs);
        $styles['radius'] = $attrs['border-radius'];

        $this->doc->graphics->drawRect(
            $attrs['x'],
            $attrs['y'],
            $attrs['width'],
            $attrs['height'],
            $styles
        );
    }

    public function renderStaticEllipse(array $attrs)
    {
        $this->doc->graphics->drawEllipse(
            $attrs['cx'],
            $attrs['cy'],
            $attrs['rx'],
            $attrs['ry'],
            $this->buildGraphicStyles($attrs)
        );
    }

    public function renderStaticLine(array $attrs)
    {
        $this->doc->graphics->drawLine(
            $attrs['x1'],
            $attrs['y1'],
            $attrs['x2'],
            $attrs['y2'],
            $this->buildGraphicStyles($attrs)
        );
    }


    public function renderStaticImage(array $attrs)
    {
        $this->doc->graphics->drawBase64Image(
            $attrs['data']['base64'],
            $attrs['x'],
            $attrs['y'],
            $attrs['width'],
            $attrs['height']
        );
    }
}
