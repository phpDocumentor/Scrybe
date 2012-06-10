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

namespace phpDocumentor\Scrybe\Template;

interface TemplateInterface
{
    public function __construct();
    public function decorate($contents, array $options = array());
    public function setName($name);
    public function setPath($path);
    public function setExtension($extension);
}
