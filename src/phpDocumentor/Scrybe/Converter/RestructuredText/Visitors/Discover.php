<?php
/**
 * phpDocumentor
 *
 * PHP Version 5
 *
 * @author    Mike van Riel <mike.vanriel@naenius.com>
 * @copyright 2010-2011 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Scrybe\Converter\RestructuredText\Visitors;

class Discover extends \ezcDocumentRstXhtmlBodyVisitor
{
    /** @var \phpDocumentor\Scrybe\Converter\RestructuredText\Document */
    protected $rst;

    /**
     * @return \phpDocumentor\Scrybe\Converter\RestructuredText\Document
     */
    public function getDocument()
    {
        return $this->rst;
    }

    protected function visitSection(\DOMNode $root, \ezcDocumentRstSectionNode $node)
    {
        /** @var \phpDocumentor\Scrybe\Converter\Metadata\TableOfContents $toc  */
        $toc = $this->getDocument()->getConverter()->getTableOfContents();
        $entry = new \phpDocumentor\Scrybe\Converter\Metadata\TableOfContents\Entry();
        $entry->setName($this->nodeToString($node->title));
        $entry->setLevel($node->depth);
        $entry->setFilename($this->getDocument()->getFile()->getFilename());
        $toc[$this->getDocument()->getFile()->getFilename()][] = $entry;

        parent::visitSection($root, $node);
    }

}
