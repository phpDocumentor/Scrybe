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

namespace phpDocumentor\Scrybe\Converter;

interface ToLatexInterface
{
    public function setTitle($title);
    public function setAuthor($author);
    public function setCoverLogo($cover_logo);
    public function setTableOfContents($table_of_contents);
}
