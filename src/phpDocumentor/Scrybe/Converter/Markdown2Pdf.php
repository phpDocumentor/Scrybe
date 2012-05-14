<?php

namespace phpDocumentor\Scrybe\Converter;

use \phpDocumentor\Scrybe;
use \phpDocumentor\Scrybe\File\File;

class Markdown2Pdf extends Markdown2Latex
{
    protected function checkAvailability()
    {
        parent::checkAvailability();

        if ((bool)(`pdflatex -v 2>&1` !== null)) {
            return;
        }

        throw new \RuntimeException(
            'Latex libraries are required to convert to PDF, specifically the '
            .'`pdflatex` executable must be available'
        );
    }

    public function execute(Scrybe\File\Collection $files)
    {
        $file = current(parent::execute($files));
        $source_file = escapeshellarg($file->getRealPath());
        $root = realpath($this->getDestinationRoot());

        // need to move directory as pandoc expects images etc. to come from
        // that root
        chdir($files->getProjectRoot());

        passthru(
            'pdflatex -interaction=nonstopmode -output-directory='.$root.' '.$source_file
        );

        if (!file_exists($root.DIRECTORY_SEPARATOR.'documentation.pdf')) {
            throw new \RuntimeException(
                'An error occurred during generation of the PDF file'
            );
        }

        $pdf = file_get_contents($root.DIRECTORY_SEPARATOR.'documentation.pdf');
        return array($this->createDestinationFile(
            $root .DIRECTORY_SEPARATOR.'documentation.pdf', $pdf
        ));
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return 'pdf';
    }
}
