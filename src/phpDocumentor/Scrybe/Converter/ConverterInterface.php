<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @author    Mike van Riel <mike.vanriel@naenius.com>
 * @copyright 2010-2011 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Scrybe\Converter;

use phpDocumentor\Fileset\Collection;
use phpDocumentor\Scrybe\Template\TemplateInterface;

/**
 * This interface provides a basic contract between the Converters and all
 * classes that want to use them.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
interface ConverterInterface
{
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
     * @param TemplateInterface $template Template used to decorate the
     *     output with.
     *
     * @see DESTINATION_RESULT to use as destination to return data.
     *
     * @return string[]|null
     */
    public function convert(Collection $source, TemplateInterface $template);

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

    /**
     * Returns the AssetManager that keep track of which assets are used.
     *
     * @return \phpDocumentor\Scrybe\Converter\Metadata\Assets
     */
    public function getAssets();

    /**
     * Returns the table of contents object that keeps track of all
     * headings and their titles.
     *
     * @return \phpDocumentor\Scrybe\Converter\Metadata\TableOfContents
     */
    public function getTableOfContents();

    /**
     * Returns the glossary object that keeps track of all the glossary terms
     * that have been provided.
     *
     * @return \phpDocumentor\Scrybe\Converter\Metadata\Glossary
     */
    public function getGlossary();

}
