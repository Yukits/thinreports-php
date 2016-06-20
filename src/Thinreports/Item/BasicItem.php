<?php

/*
 * This file is part of the Thinreports PHP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Thinreports\Item;

use Thinreports\ReportInterface;
use Thinreports\Item\Style;
use Thinreports\Service;

class BasicItem extends AbstractItem
{
    const TYPE_NAME = 'basic';

    private $type_formatter;

    /**
     * {@inheritdoc}
     */
    public function __construct(ReportInterface\iParent $parent, array $format)
    {
        parent::__construct($parent, $format);
        $this->type_formatter = Service\TypeFormat::newInstance("0.9.0");


        switch (true) {
            case $this->isImage():
                $this->style = new Style\BasicStyle($format);
                break;
            case $this->isText():
                $this->style = new Style\TextStyle($format);
                break;
            default:
                $this->style = new Style\GraphicStyle($format);
                break;
        }
    }

    /**
     * @access private
     *
     * @return boolean
     */
    public function isImage()
    {
        return $this->type_formatter->getTypeFormat()['image'];
    }

    /**
     * @access private
     *
     * @return boolean
     */
    public function isText()
    {
        return $this->type_formatter->getTypeFormat()['text'];
    }

    /**
     * @access private
     *
     * @return boolean
     */
    public function isRect()
    {
        return $this->type_formatter->getTypeFormat()['rect'];
    }

    /**
     * @access private
     *
     * @return boolean
     */
    public function isEllipse()
    {
        return $this->type_formatter->getTypeFormat()['ellipse'];
    }

    /**
     * @access private
     *
     * @return boolean
     */
    public function isLine()
    {
        return $this->type_formatter->getTypeFormat()['line'];
    }

    /**
     * {@inheritdoc}
     */
    public function getBounds()
    {
        $svg_attrs = $this->getSVGAttributes();

        switch (true) {
            case $this->isImage() || $this->isRect():
                return array(
                    'x'      => $svg_attrs['x'],
                    'y'      => $svg_attrs['y'],
                    'width'  => $svg_attrs['width'],
                    'height' => $svg_attrs['height']
                );
                break;
            case $this->isText():
                return $this->format['box'];
                break;
            case $this->isEllipse():
                return array(
                    'cx' => $svg_attrs['cx'],
                    'cy' => $svg_attrs['cy'],
                    'rx' => $svg_attrs['rx'],
                    'ry' => $svg_attrs['ry']
                );
                break;
            case $this->isLine():
                return array(
                    'x1' => $svg_attrs['x1'],
                    'y1' => $svg_attrs['y1'],
                    'x2' => $svg_attrs['x2'],
                    'y2' => $svg_attrs['y2']
                );
                break;
        }
    }
}
