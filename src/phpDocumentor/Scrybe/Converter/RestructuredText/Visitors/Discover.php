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
    /** @var Rst */
    protected $rst;

    protected function visitSection(\DOMNode $root, \ezcDocumentRstSectionNode $node)
    {
        /** @var \phpDocumentor\Scrybe\Converter\Metadata\TableOfContents $toc  */
        $toc = $this->rst->getMetaData('toc');
        $entry = new \phpDocumentor\Scrybe\Converter\Metadata\TableOfContents\Entry();
        $entry->setName($this->nodeToString($node->title));
        $entry->setLevel($node->depth);
        $entry->setFilename($this->rst->getMetaData('file'));
        $toc[$this->rst->getMetaData('file')][] = $entry;

        parent::visitSection($root, $node);
    }

    protected function visitDirective(\DOMNode $root, \ezcDocumentRstNode $node)
    {
        /** @var \phpDocumentor\Scrybe\Converter\Metadata\Assets $assets  */
//        $assets = $this->rst->getMetaData('assets');
//        $assets
        var_dump($node->identifier);
        var_dump(dirname($this->rst->getMetaData('file')).'/'.trim($node->parameters));

        parent::visitDirective($root, $node);
    }

    /**
     * @return \phpDocumentor\Scrybe\Converter\RestructuredText\Visitors\Rst
     */
    public function getRst()
    {
        return $this->rst;
    }
}
