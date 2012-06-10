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

namespace phpDocumentor\Scrybe\Converter\RestructuredText\Roles;

class Doc extends \ezcDocumentRstTextRole implements \ezcDocumentRstXhtmlTextRole
{
    /**
     * Transform text role to docbook.
     *
     * Create a docbook XML structure at the text roles position in the
     * document.
     *
     * @param \DOMDocument $document
     * @param \DOMElement $root
     */
    public function toDocbook(\DOMDocument $document, \DOMElement $root)
    {

    }

    /**
     * Transform text role to HTML.
     *
     * Create a XHTML structure at the text roles position in the document.
     *
     * @param \DOMDocument $document
     * @param \DOMElement $root
     */
    public function toXhtml(\DOMDocument $document, \DOMElement $root)
    {
        $content = '';
        foreach($this->node->nodes as $node) {
            $content .= $node->token->content;
        }

        $link = $document->createElement(
            'a',
            str_replace(
                array('-', '_'),
                ' ',
                ucfirst(ltrim(substr(
                    htmlspecialchars($content),
                    strrpos($content, '/')
                ), '\\/'))
            )
        );
        $root->appendChild($link);
        $link->setAttribute(
            'href', str_replace('\\', '/', $content).'.html'
        );
    }
}