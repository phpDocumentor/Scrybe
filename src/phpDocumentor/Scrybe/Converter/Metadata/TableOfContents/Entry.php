<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @author    Mike van Riel <mike.vanriel@naenius.com>
 * @copyright 2012 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Scrybe\Converter\Metadata\TableOfContents;

/**
 * The Table of Contents entry provides essential information on the current
 * entry, it's place in the structure and where it points to.
 *
 * This class explicitly does not have parents or child entries as hierarchy is
 * deduced from the position in the TableOfContents collection and the nesting
 * level for this entry.
 *
 * In the future this might be changed for a more robust and flexible system.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
class Entry
{
    /** @var int Indicates the nesting level of the current entry. */
    protected $level;

    /** @var string Provides the name for this entry. */
    protected $name;

    /** @var string Which file does this entry belong to. */
    protected $filename;

    /**
     * Sets the filename for this entry.
     *
     * @param string $filename
     *
     * @return void
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Returns the filename in which this entry resides.
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Sets the nesting level for this entry.
     *
     * Combined with the position in the table of contents can the hierarchy be
     * deduced for the table of contents.
     *
     * @param int $level
     *
     * @return void
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * Returns the nesting level for this entry.
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Sets the human-interpretable name, or title, for this entry.
     *
     * @param string $name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the human-interpretable name, or title, for this entry.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}