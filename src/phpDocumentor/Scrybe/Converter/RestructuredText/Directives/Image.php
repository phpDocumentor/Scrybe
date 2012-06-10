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

namespace phpDocumentor\Scrybe\Converter\RestructuredText\Directives;

class Image extends \ezcDocumentRstImageDirective
{
    public function toXhtml(\DOMDocument $document, \DOMElement $root)
    {
//        $this->visitor->getRst()->getMetaData('assets')->offsetSet(
//            dirname($this->node->parameters)
//        );
        parent::toXhtml($document, $root);
    }
}