<?php

/*
 * This file is part of the Thinreports PHP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Thinreports\Generator\Renderer;

use Thinreports\Generator\PDF;

/**
 * @access private
 */
abstract class AbstractRenderer
{
    /**
     * @var PDF\Document
     */
    protected $doc;

    /**
     * @param PDF\Document $doc
     */
    public function __construct(PDF\Document $doc)
    {
        $this->doc = $doc;
    }

    public function buildGraphicStyles(array $attrs)
    {
//        if (array_key_exists('stroke-opacity', $attrs)
//            && $svg_attrs['stroke-opacity'] === '0') {
//            $stroke_width = 0;
//        } else {
//            $stroke_width = $svg_attrs['stroke-width'];
//        }

        return array(
            'stroke_color' => $attrs['style']['border-color'],
            'stroke_width' => $attrs['style']['border-width'],
            'stroke_dash'  => $attrs['style']['border-style'],
            'fill_color'   => $attrs['style']['fill-color']
        );
    }


    public function buildTextStyles(array $attrs)
    {
        return array(
            'font_family'    => $attrs['style']['font-family'],
            'font_size'      => $attrs['style']['font-size'],
            'font_style'     => $attrs['style']['font-style'],
            'color'          => $attrs['style']['color'],
            'align'          => $attrs['style']['text-align'],
            'letter_spacing' => $attrs['letter-spacing']
        );
    }
//
//    /**
//     * @param array $svg_attrs
//     * @return string[]
//     */
//    public function buildFontStyle(array $svg_attrs)
//    {
//        $styles = array();
//
//        if ($svg_attrs['font-weight'] === 'bold') {
//            $styles[] = 'bold';
//        }
//        if ($svg_attrs['font-style'] === 'italic') {
//            $styles[] = 'italic';
//        }
//
//        $decoration = $svg_attrs['text-decoration'];
//
//        if (!empty($decoration) && $decoration !== 'none') {
//            $decorations = explode(' ', $decoration);
//
//            if (in_array('underline', $decorations)) {
//                $styles[] = 'underline';
//            }
//            if (in_array('line-through', $decorations)) {
//                $styles[] = 'strikethrough';
//            }
//        }
//        return $styles;
//    }

//    /**
//     * @param string $align
//     * @return string
//     */
//    public function buildTextAlign($align)
//    {
//        switch ($align) {
//            case 'start':
//                return 'left';
//                break;
//            case 'middle':
//                return 'center';
//                break;
//            case 'end':
//                return 'right';
//                break;
//            default:
//                return 'left';
//        }
//    }

    /**
     * @param string|null $valign
     * @return string
     */
    public function buildVerticalAlign($valign)
    {
        return $valign ?: 'top';
    }

//    /**
//     * @param string|null $letter_spacing
//     * @return string|null
//     */
//    public function buildLetterSpacing($letter_spacing)
//    {
//        if (in_array($letter_spacing, array(null, 'auto', 'normal'))) {
//            return null;
//        } else {
//            return $letter_spacing;
//        }
//    }

    /**
     * @param array $svg_attrs
     * @return string
     */
    public function extractBase64Data(array $svg_attrs)
    {
        return preg_replace('/^data:image\/[a-z]+?;base64,/',
                            '', $svg_attrs['xlink:href']);
    }
}
