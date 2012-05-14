<?php

namespace phpDocumentor\Scrybe\Converter;

use \phpDocumentor\Scrybe;
use \phpDocumentor\Scrybe\File\File;

class ReST2Latex extends Markdown2Latex
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
