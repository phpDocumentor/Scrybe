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

namespace phpDocumentor\Scrybe\Converter;

/**
 * Interface that dictates the custom options that all converters that convert
 * to Latex should have.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
interface ToLatexInterface
{
    /**
     * Sets the title that is supposed to be on the front page.
     *
     * @param string $title
     *
     * @return void
     */
    public function setTitle($title);

    /**
     * Sets the author name that is supposed to be on the frontpage.
     *
     * @param string $author
     *
     * @return void
     */
    public function setAuthor($author);

    /**
     * Sets the filename used as logo or cover picture.
     *
     * The image location should be absolute or relative to the destination
     * location.
     *
     * @param string $cover_logo
     *
     * @return void
     */
    public function setCoverLogo($cover_logo);
}
