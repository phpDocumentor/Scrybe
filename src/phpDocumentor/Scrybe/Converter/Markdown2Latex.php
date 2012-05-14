<?php

namespace phpDocumentor\Scrybe\Converter;

use \phpDocumentor\Scrybe;
use \phpDocumentor\Scrybe\File\File;

class Markdown2Latex extends ConverterAbstract implements Templateable
{
    protected $pandoc_input_format = 'markdown';

    protected $title;
    protected $author;
    protected $cover_logo;
    protected $table_of_contents;

    protected function checkAvailability()
    {
        if ((bool)(`pandoc -v 2>&1` === null)) {
            throw new \RuntimeException(
                'pandoc (http://johnmacfarlane.net/pandoc) is required to convert'
                .' from Markdown to Latex'
            );
        }
    }

    public function execute(Scrybe\File\Collection $files)
    {
        $this->checkAvailability();

        if ($files->count() === 0) {
            throw new \InvalidArgumentException(
                'No parsable files have been found; please verify that you have'
                .' chosen the correct input type and that the files have the '
                .'correct extension ('.$this->getSourceExtension().')'
            );
        }

        $filenames = array();
        foreach($files as $file) {
            $filenames[] = escapeshellarg($this->convert($file));
        }
        $filenames_argument = implode(' ', $filenames);

        $destination_filename = $this->getDestinationRoot()
            .DIRECTORY_SEPARATOR.'documentation.tex';
        $this->createDirectoryIfMissing(dirname($destination_filename));

        return array($this->createDestinationFile(
            $destination_filename,
            $this->applyTemplate(
                `pandoc --toc --chapters -N -f {$this->pandoc_input_format} -t latex {$filenames_argument}`,
                array(
                    'title'     => $this->getTitle(),
                    'author'    => $this->getAuthor(),
                    'coverlogo' => $this->getCoverLogo(),
                    'toc'       => $this->hasTableOfContents()
                )
            )
        ));
    }

    public function convert(File $file)
    {
        return $file->getPathname();
    }

    /**
     * @return string
     */
    public function getSourceExtension()
    {
        return 'md';
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return 'tex';
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setCoverLogo($cover_logo)
    {
        $this->cover_logo = $cover_logo;
    }

    public function getCoverLogo()
    {
        return $this->cover_logo;
    }

    public function setTableOfContents($table_of_contents)
    {
        $this->table_of_contents = $table_of_contents;
    }

    public function hasTableOfContents()
    {
        return $this->table_of_contents;
    }
}
