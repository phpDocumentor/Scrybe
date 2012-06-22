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

/**
 * A specialized RestructuredText Parser/Visitor to aid in the discovery phase.
 *
 * This class collects all headings and their titles and populates the
 * TableOfContents collection.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
class Discover extends \ezcDocumentRstXhtmlBodyVisitor
{
    /** @var \phpDocumentor\Scrybe\Converter\RestructuredText\Document */
    protected $rst;

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

    /**
     * Visitor for the section heading used to populate the TableOfContents.
     *
     * This method interprets the heading and its containing text and adds new
     * entries to the TableOfContents object in the RestructuredText document.
     *
     * @param \DOMNode                   $root
     * @param \ezcDocumentRstSectionNode $node
     *
     * @see getDocument() for the document containing the TableOfContents.
     * @see \phpDocumentor\Scrybe\Converter\Metadata\TableOfContents for the
     *     Table of Contents class.
     *
     * @return void
     */
    protected function visitSection(\DOMNode $root, \ezcDocumentRstSectionNode $node)
    {
        /** @var \phpDocumentor\Scrybe\Converter\Metadata\TableOfContents $toc  */
        $toc      = $this->getDocument()->getConverter()->getTableOfContents();
        $filename = $this->getDocument()->getFile()->getFilename();

        $entry = new \phpDocumentor\Scrybe\Converter\Metadata\TableOfContents\Entry();
        $entry->setName($this->nodeToString($node->title));
        $entry->setLevel($node->depth);
        $entry->setFilename($filename);
        $toc[$filename][] = $entry;

        parent::visitSection($root, $node);
    }

}
