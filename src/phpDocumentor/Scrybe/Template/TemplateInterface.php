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

namespace phpDocumentor\Scrybe\Template;

interface TemplateInterface
{
    public function __construct();
    public function setName($name);
    public function setPath($path);
    public function setExtension($extension);
    public function decorate($contents, array $options = array());
}
