<?php

namespace phpDocumentor\Scrybe\Converter;

use \phpDocumentor\Scrybe;
use \phpDocumentor\Scrybe\File\File;

class ReST2Pdf extends Markdown2Pdf
{
    protected $pandoc_input_format = 'rst';

    /**
     * @return string
     */
    public function getSourceExtension()
    {
        return 'rst';
    }
}
