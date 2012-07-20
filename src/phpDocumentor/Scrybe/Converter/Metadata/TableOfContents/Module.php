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
 * The Table of Contents module represents an independent section of the
 * documentation.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
class Module
{
    /**
     * @var File
     */
    protected $table_of_contents_root = null;

    /**
     * Initializes the module and sets the root File object.
     *
     * @param File $root
     */
    public function __construct(File $root)
    {
        $this->table_of_contents_root = $root;
    }

    /**
     * Returns a single File object that represents the root of the Table of
     * Contents for this module.
     *
     * @return File
     */
    public function getTableOfContentsRoot()
    {
        return $this->table_of_contents_root;
    }
}
