<?php

namespace phpDocumentor\Scrybe\Converter;

use \phpDocumentor\Scrybe;
use \phpDocumentor\Scrybe\File\File;

class Markdown2Html extends ConverterAbstract
{
    protected $has_pandoc = false;

    function __construct()
    {
        $this->has_pandoc = (bool)(`pandoc -v 2>&1` !== null);
    }

    public function convert(File $file)
    {
        return $this->has_pandoc
            ? $this->convertWithPandoc($file)
            : $this->convertUsingMarkdownExtra($file);
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
        return 'html';
    }

    /**
     * @param \phpDocumentor\Scrybe\File\File $file
     *
     * @return string
     */
    public function convertUsingMarkdownExtra(File $file)
    {
        $markdown_parser = new \dflydev\markdown\MarkdownExtraParser();
        $contents = $markdown_parser->transform($file->fread());
        return $contents;
    }

    /**
     * @param \phpDocumentor\Scrybe\File\File $file
     *
     * @return string
     */
    public function convertWithPandoc(File $file)
    {
        return `pandoc -f markdown -t html -5 {$file->getPathname()}`;
    }
}
