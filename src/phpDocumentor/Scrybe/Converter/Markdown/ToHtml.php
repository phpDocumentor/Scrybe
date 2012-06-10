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

namespace phpDocumentor\Scrybe\Converter\Markdown;

use phpDocumentor\Fileset\Collection;
use phpDocumentor\Fileset\File;
use phpDocumentor\Scrybe\Converter\Definition;
use phpDocumentor\Scrybe\Converter\PandocConverterAbstract;

class ToHtml extends PandocConverterAbstract
{
    /**
     * Initializes this converter and sets the definition.
     *
     * @param Definition\Definition $definition
     */
    function __construct(Definition\Definition $definition)
    {
        try {
            parent::__construct($definition);
        } catch(\RuntimeException $e) {
            $this->pandoc = null;
        }
    }

    /**
     * Converts the given $source using the formats that belong to this
     * converter.
     *
     * This method will return null unless the 'scrybe://result' is used.
     *
     * @param Collection $source      Collection of input files.
     * @param string     $destination Any file or stream to which PHP can write
     *     or any of the defined destination constants.
     *
     * @see DESTINATION_RESULT to use as destination to return data.
     *
     * @return string[]|null
     */
    public function convert(Collection $source, $destination)
    {
        $result = array();

        /** @var File $file */
        foreach($source as $file) {
            $converted_contents = $this->pandoc !== null
                ? $this->convertWithPandoc($file)
                : $this->convertUsingMarkdownExtra($file);

            $filename = $this->getDestinationFilename($file);
            if ($destination === self::DESTINATION_RESULT) {
                $result[$filename] = $converted_contents;
            } else {
                $this->saveContentsToPath(
                    $destination . '/' . substr(
                        $filename, strlen($source->getProjectRoot())
                    ),
                    $converted_contents
                );
                $result = null;
            }
        }

        return $result;
    }

    /**
     * Returns the filename used for the output path.
     *
     * @param Fileset\File $file
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
     * Stores the contents to the provided path and creates the destination
     * folder if it doesn't exist.
     *
     * @param string $destination
     * @param string $converted_contents
     */
    protected function saveContentsToPath($destination, $converted_contents)
    {
        $destination_path = dirname($destination);
        if (!file_exists($destination_path))
        {
            mkdir($destination_path, 0777, true);
        }

        file_put_contents($destination, $converted_contents);
    }

    /**
     * @param \phpDocumentor\Fileset\File $file
     *
     * @return string
     */
    protected function convertUsingMarkdownExtra(File $file)
    {
        $markdown_parser = new \dflydev\markdown\MarkdownExtraParser();
        return $markdown_parser->transform($file->fread());
    }

    /**
     * @param \phpDocumentor\Fileset\File $file
     *
     * @return string
     */
    protected function convertWithPandoc(File $file)
    {
        return $this->pandoc->convert('markdown', 'html', $file->getPathname());
    }

}
