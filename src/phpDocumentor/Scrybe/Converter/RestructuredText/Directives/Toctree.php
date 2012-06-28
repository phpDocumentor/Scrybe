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

namespace phpDocumentor\Scrybe\Converter\RestructuredText\Directives;

/**
 * Directive used to process `.. toctree::` and insert entries from the table
 * of contents.
 *
 * This directive tries to match the file with an entry in the table of contents
 * during the creation phase. If a document is found it will generate a
 * mini-table of contents at that location with the depth given using the
 * `:maxdepth:` parameter.
 *
 * This directive is inspired by
 * {@link http://sphinx.pocoo.org/concepts.html#the-toc-tree Sphinx' toctree}
 * directive.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
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
     *
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
     *
     * @todo use the TableofContents collection to extract a sublisting up to the
     *     given depth or 2 if none is provided
     *
     * @return void
     */
    public function toXhtml(\DOMDocument $document, \DOMElement $root)
    {
        $list = $document->createElement('ol');
        $root->appendChild($list);

        $line = '';
        /** @var \ezcDocumentRstToken $token */
        foreach($this->node->tokens as $token) {
            if ($token->type === 2) {
                $line = trim($line);
                if ($line) {
                    $list_item = $document->createElement('li');
                    $list->appendChild($list_item);

                    $link = $document->createElement('a', $this->getCaption($line));
                    $list_item->appendChild($link);
                    $link->setAttribute(
                        'href', str_replace('\\', '/', $line).'.html'
                    );
                }
                $line = '';
            }

            if ($token->type !== 5 && $token->type !== 4) {
                continue;
            }

            $line .= $token->content;
        }
    }

    /**
     * Retrieves the caption for the given $token.
     *
     * The caption is retrieved by converting the filename to a human-readable
     * format.
     *
     * @param \ezcDocumentRstToken $content
     *
     * @todo Use the TableOfContents collection to get the caption name.
     *
     * @return string
     */
    protected function getCaption($content)
    {
        return str_replace(
            array('-', '_'),
            ' ',
            ucfirst(
                ltrim(
                    substr(
                        htmlspecialchars($content), strrpos($content, '/')
                    ), '\\/')
            )
        );
    }
}