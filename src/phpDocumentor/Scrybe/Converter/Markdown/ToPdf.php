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

use phpDocumentor\Scrybe;
use phpDocumentor\Scrybe\Converter\ConverterInterface;
use phpDocumentor\Scrybe\Converter\ToPdfInterface;
use phpDocumentor\Fileset\File;

class ToPdf extends ToLatex implements ToPdfInterface
{
    public function convert(\phpDocumentor\Fileset\Collection $source, $destination)
    {
        if ($destination === ConverterInterface::DESTINATION_RESULT) {
            throw new \InvalidArgumentException(
                'The PDF converter needs to write output to disk'
            );
        }

        parent::convert($source, $destination);

        // need to move directory as pandoc expects images etc. to come from
        // that root
        chdir($destination);

        passthru(
            'pdflatex -interaction=nonstopmode -output-directory='
                . $destination . ' '.$this->getDestinationFilename()
        );

        if (!file_exists($destination . '/documentation.pdf')) {
            throw new \RuntimeException(
                'An error occurred during generation of the PDF file'
            );
        }

        return null;
    }

    protected function getDestinationFilename()
    {
        return parent::getDestinationFilename().'tex';
    }
}