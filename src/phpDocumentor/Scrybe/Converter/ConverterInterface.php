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

use phpDocumentor\Fileset\Collection;
use phpDocumentor\Scrybe\Template\TemplateInterface;


interface ConverterInterface
{
    /**
     * Constant used to let applications tell converters to return the results
     * instead of dumping it to the provided file.
     *
     * Please note that this streamwrapper is fictive and cannot be used beyond
     * this context.
     *
     * @var string
     */
    const DESTINATION_RESULT = 'scrybe://result';

    const DESTINATION_STDIN  = 'php://stdin';
    const DESTINATION_STDERR = 'php://stderr';

    /**
     * Standard option used to convey the name of the template to use.
     *
     * @see \phpDocumentor\Scrybe\Command\Manual\ConverCommandAbstract::execute()
     */
    const OPTION_TEMPLATE = 'template';

    /**
     * Initializes this converter and sets the definition.
     *
     * @param Definition\Definition $definition
     */
    public function __construct(Definition\Definition $definition);

    /**
     * Converts the given $source using the formats that belong to this
     * converter.
     *
     * This method will return null unless the 'scrybe://result' is used.
     *
     * @param Collection        $source      Collection of input files.
     * @param string            $destination Any file or stream to which
     *     PHP can write or any of the defined destination constants.
     * @param TemplateInterface $template Template used to decorate the
     *     output with.
     *
     * @see DESTINATION_RESULT to use as destination to return data.
     *
     * @return string[]|null
     */
    public function convert(
        Collection $source, $destination, TemplateInterface $template
    );

    /**
     * Returns the definition for this Converter.
     *
     * @return Definition\Definition
     */
    public function getDefinition();

    /**
     * Sets an option which can optionally be used in converters.
     *
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    public function setOption($name, $value);
}
