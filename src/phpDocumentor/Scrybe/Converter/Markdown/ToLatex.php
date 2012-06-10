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
use phpDocumentor\Scrybe\Converter\PandocConverterAbstract;
use phpDocumentor\Scrybe\Converter\ToLatexInterface;
use phpDocumentor\Scrybe\Converter\Definition;

class ToLatex extends PandocConverterAbstract implements ToLatexInterface
{
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
        $template = new \phpDocumentor\Scrybe\Template\TwigTemplate(
            'layout', current($this->definition->getOutputFormat()->getExtensions())
        );

        $result = array($this->getDestinationFilename() => $template->decorate(
            $this->pandoc->convert(
                'markdown', 'latex', array_keys($source->getArrayCopy())
            ), $this->options
        ));

        if ($destination !== self::DESTINATION_RESULT) {
            file_put_contents(
                $destination . '/' . key($result),
                reset($result)
            );
            $result = null;
        }

        return $result;
    }

    public function setTitle($title)
    {
        $this->setOption('title', $title);
    }

    public function getTitle()
    {
        return $this->getOption('title');
    }

    public function setAuthor($author)
    {
        $this->setOption('author', $author);
    }

    public function getAuthor()
    {
        return $this->getOption('author');
    }

    public function setCoverLogo($cover_logo)
    {
        $this->setOption('cover_logo', $cover_logo);
    }

    public function getCoverLogo()
    {
        return $this->getOption('cover_logo');
    }

    public function setTableOfContents($table_of_contents)
    {
        $this->setOption('table_of_contents', $table_of_contents);
    }

    public function hasTableOfContents()
    {
        return $this->getOption('table_of_contents');
    }

    protected function getDestinationFilename()
    {
        return $this->definition->getOutputFormat()->convertFilename(
            'documentation.md'
        );
    }
}
