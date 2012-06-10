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

abstract class PandocConverterAbstract extends BaseConverter
{
    /** @var \phpDocumentor\Scrybe\Pandoc */
    protected $pandoc = null;

    function __construct(Definition\Definition $definition)
    {
        parent::__construct($definition);

        $this->pandoc = new \phpDocumentor\Scrybe\Pandoc();
    }
}
