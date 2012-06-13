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

/**
 * Visitor for Toctree
 */
class Toctree extends \ezcDocumentRstDirective
    implements \ezcDocumentRstXhtmlDirective
{
    /**
     * Transform directive to docbook
     *
     * Create a docbook XML structure at the directives position in the
     * document.
     *
     * @param \DOMDocument $document
     * @param \DOMElement $root
     * @return void
     */
    public function toDocbook(\DOMDocument $document, \DOMElement $root)
    {
    }

    /**
     * Transform directive to HTML
     *
     * Create a XHTML structure at the directives position in the document.
     *
     * @param \DOMDocument $document
     * @param \DOMElement $root
     * @return void
     */
    public function toXhtml(\DOMDocument $document, \DOMElement $root)
    {
        $list = $document->createElement('ul');
        $root->appendChild($list);

        /** @var \ezcDocumentRstToken $token */
        foreach($this->node->tokens as $token) {
            if ($token->type !== 5) {
                continue;
            }

            $list_item = $document->createElement('li');
            $list->appendChild($list_item);
            $link = $document->createElement(
                'a',
                str_replace(
                    array('-', '_'),
                    ' ',
                    ucfirst(ltrim(substr(
                        htmlspecialchars($token->content),
                        strrpos($token->content, '/')
                    ), '\\/'))
                )
            );
            $list_item->appendChild($link);
            $link->setAttribute(
                'href', str_replace('\\', '/', $token->content).'.html'
            );
        }
    }
}