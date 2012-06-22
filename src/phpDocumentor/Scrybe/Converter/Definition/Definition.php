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

namespace phpDocumentor\Scrybe\Converter\Definition;

use phpDocumentor\Scrybe\Converter\Format;

/**
 * Defines the basic properties for a single conversion process.
 *
 * @author  Mike van Riel <mike.vanriel@naenius.com>
 */
class Definition
{
    /** @var \phpDocumentor\Scrybe\Converter\Format\Format */
    protected $input_format;

    /** @var \phpDocumentor\Scrybe\Converter\Format\Format */
    protected $output_format;

    function __construct(
        Format\Format $input_format, Format\Format $output_format
    ) {
        $this->input_format = $input_format;
        $this->output_format = $output_format;
    }

    /**
     * Returns the format used as input.
     *
     * @return \phpDocumentor\Scrybe\Converter\Format\Format
     */
    public function getInputFormat()
    {
        return $this->input_format;
    }

    /**
     * Returns the format used as output.
     *
     * @return \phpDocumentor\Scrybe\Converter\Format\Format
     */
    public function getOutputFormat()
    {
        return $this->output_format;
    }
}
