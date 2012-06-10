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

namespace phpDocumentor\Scrybe\Converter\Definition;

use phpDocumentor\Scrybe\Converter\Format;

class Factory
{
    protected $format_collection = null;

    function __construct(Format\Collection $formats)
    {
        $this->format_collection = $formats;
    }

    /**
     * Creates a definition of the given input and output formats.
     *
     * @param string $input_format
     * @param string $output_format
     *
     * @return \phpDocumentor\Scrybe\Converter\Definition\Definition
     */
    public function get($input_format, $output_format)
    {
        return new \phpDocumentor\Scrybe\Converter\Definition\Definition(
            $this->format_collection[$input_format],
            $this->format_collection[$output_format]
        );
    }
}
