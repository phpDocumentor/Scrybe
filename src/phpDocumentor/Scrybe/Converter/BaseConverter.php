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
use phpDocumentor\Fileset\File;
use phpDocumentor\Scrybe\Template\TemplateInterface;

abstract class BaseConverter implements ConverterInterface
{
    /** @var Definition\Definition */
    protected $definition = null;

    /** @var string[] */
    protected $options = array();

    /** @var string */
    protected $destination;

    /** @var Collection */
    protected $fileset;

    /**
     * Initializes this converter and sets the definition.
     *
     * @param Definition\Definition $definition
     */
    function __construct(Definition\Definition $definition)
    {
        $this->definition = $definition;
    }

    /**
     * Returns the definition for this Converter.
     *
     * @return Definition\Definition
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Sets an option with the given name.
     *
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * Returns the option with the given name or null if the option does not
     * exist.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function getOption($name)
    {
        return isset($this->options[$name])
            ? $this->options[$name]
            : null;
    }

    /**
     * Configures and initializes the subcomponents specific to this converter.
     *
     * @return void
     */
    public function configure()
    {
    }

    /**
     * Discovers the data that is spanning all files.
     *
     * This method tries to find any data that needs to be collected before
     * the actual creation and substitution phase begins.
     *
     * Examples of data that needs to be collected during an initial phase is
     * a table of contents, list of document titles for references, assets
     * and more.
     *
     * @see manual://extending#build_cycle for more information regarding the
     *     build process.
     *
     * @return void
     */
    abstract protected function discover();

    /**
     * Converts the input files into one or more output files in the intended
     * format.
     *
     * This method reads the files, converts them into the correct format and
     * returns the contents of the conversion if the destination is
     * scrybe://result or writes the files directly to the destination location.
     *
     * The template is used to decorate the individual files and can be obtained
     * using the `\phpDocumentor\Scrybe\Template\Factory` class.
     *
     * @param TemplateInterface $template
     *
     * @see manual://extending#build_cycle for more information regarding the
     *     build process.
     *
     * @return string[]|null The contents of the resulting file(s) or null if
     *     the files are written directly to file.
     */
    abstract protected function create(TemplateInterface $template);

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
    ) {
        $this->fileset      = $source;
        $this->destination  = $destination;

        $template->setExtension(
            current($this->definition->getOutputFormat()->getExtensions())
        );

        $this->configure();
        $this->discover();
        return $this->create($template);
    }

    /**
     * Returns the filename used for the output path.
     *
     * @param File $file
     *
     * @return string
     */
    protected function getDestinationFilename(File $file)
    {
        return $this->definition->getOutputFormat()->convertFilename(
            $file->getRealPath()
        );
    }

    /**
     * Returns the filename relative to the Project Root of the fileset.
     *
     * @param File $file
     *
     * @return string
     */
    protected function getDestinationFilenameRelativeToProjectRoot(File $file)
    {
        return substr(
            $this->getDestinationFilename($file),
            strlen($this->fileset->getProjectRoot())
        );
    }

    /**
     * Stores the contents to the provided path and creates the destination
     * folder if it doesn't exist.
     *
     * @param string $destination
     * @param string $converted_contents
     */
    protected function saveContentsToPath($destination, $converted_contents)
    {
        $destination_path = dirname($destination);
        if (!file_exists($destination_path)) {
            mkdir($destination_path, 0777, true);
        }

        file_put_contents($destination, $converted_contents);
    }

}
