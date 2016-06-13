<?php

/*
 * This file is part of the Thinreports PHP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Thinreports;

use Thinreports\Exception;
use Thinreports\Item;
use Thinreports\Page\Page;
use Thinreports\Service\AItemManager;
use Thinreports\Service\TLFParser;

class Layout
{
    const FILE_EXT_NAME = 'tlf';


    /**
     * @param string $filename
     * @return self
     * @throws Exception\StandardException
     */
    static public function loadFile($filename)
    {
        if (pathinfo($filename, PATHINFO_EXTENSION) != self::FILE_EXT_NAME) {
            $filename .= '.' . self::FILE_EXT_NAME;
        }

        if (!file_exists($filename)) {
            throw new Exception\StandardException('Layout File Not Found', $filename);
        }

        return new self($filename,
         TLFParser::getItemManager(file_get_contents($filename, true)));
    }

    private $item_manager;
    private $identifier;

    /**
     * @param string $filename
     * @param array $deinition array('format' => array, 'item_formats' => array)
     */
    public function __construct($filename, AItemManager $item_manager)
    {
        $this->filename = $filename;
        $this->item_manager = $item_manager;
        $this->identifier = md5($this->format['svg']);
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getReportTitle()
    {
        return $this->item_manager->getTitle();
    }

    /**
     * @return string
     */
    public function getPagePaperType()
    {
        return $this->item_manager->getPaperType();
    }

    /**
     * @return string[]|null
     */
    public function getPageSize()
    {
        return $this->item_manager->getPageSize();
    }

    /**
     * @return boolean
     */
    public function isPortraitPage()
    {
        return $this->item_manager->getOrientation() === 'portrait';
    }

    /**
     * @return boolean
     */
    public function isUserPaperType()
    {
        return $this->item_manager->getPaperType === 'user';
    }

    /**
     * @access private
     *
     * @return string
     */
    public function getLastVersion()
    {
        return $this->item_manager->getTLFVersion();
    }

    // /**
    //  * @access private
    //  *
    //  * @return string
    //  */
    // public function getSVG()
    // {
    //     return $this->format['svg'];
    // }


    /**
     * @access private
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @access private
     *
     * @return array
     */
    public function getFormat()
    {
        return $this->item_manager->getFormat();
    }

    /**
     * @access private
     *
     * @return array
     */
    public function getItemFormats()
    {
        return $this->item_manager->getItemFormats();
    }
}
