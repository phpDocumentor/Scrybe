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

namespace phpDocumentor\Scrybe\Converter\RestructuredText\Visitors;

use \phpDocumentor\Scrybe\Converter\Metadata\TableOfContents;

/**
 * A specialized RestructuredText Parser/Visitor to provide assistance methods
 * for the creation phase..
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
class Creator extends \ezcDocumentRstXhtmlBodyVisitor
{
    /** @var \phpDocumentor\Scrybe\Converter\RestructuredText\Document */
    protected $rst;

    /**
     * Returns the table of contents.
     *
     * return TableOfContents $toc
     */
    public function getTableOfContents()
    {
        return $this->getDocument()->getConverter()->getTableOfContents();
    }

    /**
     * Returns the filename for this visitor.
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->getDocument()->getConverter()
            ->getDestinationFilenameRelativeToProjectRoot(
            $this->getDocument()->getFile()
        );
    }

    /**
     * Returns the filename for this visitor without an extension.
     *
     * @return string
     */
    public function getFilenameWithoutExtension()
    {
        $filename = $this->getDocument()->getFile()->getFilename();
        return substr($filename, 0, strrpos($filename, '.'));
    }

    /**
     * Returns the RestructuredText Document to retrieve the specialized
     * cross-document collections.
     *
     * @return \phpDocumentor\Scrybe\Converter\RestructuredText\Document
     */
    public function getDocument()
    {
        return $this->rst;
    }
}
