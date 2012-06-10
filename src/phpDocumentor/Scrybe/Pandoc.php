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

namespace phpDocumentor\Scrybe;

class Pandoc
{
    protected $destination_file = null;

    public function __construct()
    {
        $this->validatePandocInstallation();
    }

    /**
     * Sets a target path to write the conversion results.
     *
     * @param string|null $destination_file Path to the newly created file or
     *   null to indicate no file should be written.
     *
     * @return void
     */
    public function setDestinationFile($destination_file)
    {
        $this->destination_file = $destination_file;
    }

    /**
     * Returns the target path to write the results to or null if no direct
     * writing should occur.
     *
     * @return string|null
     */
    public function getDestinationFile()
    {
        return $this->destination_file;
    }

    /**
     * Converts the given Fileset\Collection or array of filenames from their
     * input_format to the given output_format.
     *
     * @param string $input_format
     * @param string $output_format
     * @param \phpDocumentor\Fileset\Collection|string[]|string $source
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function convert($input_format, $output_format, $source)
    {
        if (is_string($source)) {
            $source = (array)$source;
        }

        if (count($source) === 0) {
            throw new \InvalidArgumentException(
                'No parsable files have been found; please verify that you have'
                .' chosen the correct input type and that the files have the '
                .'correct extension'
            );
        }

        $process = $this->constructProcess(
            $this->buildArguments($input_format, $output_format), $source
        );
        $process->run();

        if (!$process->isSuccessful()) {
           throw new \RuntimeException(
               'The conversion using pandoc failed, the following information '
               .'was returned by pandoc: '.$process->getErrorOutput()
           );
        }

        return $process->getOutput();
    }

    protected function constructProcess($arguments, $source)
    {
        $process_builder = \Symfony\Component\Process\ProcessBuilder::create(
            array_merge(
                array('pandoc'),
                $arguments,
                $this->getFilenames($source)
            )
        );
        $process_builder->setTimeout(3600);

        return $process_builder->getProcess();
    }

    protected function validatePandocInstallation()
    {
        if ((bool)(`pandoc -v 2>&1` === null))
        {
            throw new \RuntimeException(
                'pandoc (http://johnmacfarlane.net/pandoc) is required, please '
                    . 'install this dependency and try again'
            );
        }
    }

    protected function buildArguments($input_format, $output_format)
    {
        $arguments = array(
            '--toc', // Format data to be able to use a TOC
            '--chapters',
            '-N', // Number sections
            '-5', // Toggle to output HTML5 when using the HTML output format
            '-f', $input_format,
            '-t', $output_format
        );

        if ($this->destination_file !== null)
        {
            $arguments[] = '-o';
            $arguments[] = $this->destination_file;
        } elseif($this->doesOutputFormatRequireDestinationFile($output_format)) {
            throw new \InvalidArgumentException(
                'For the epub, odt and docx output formats it is required to'
                .'provide a destination file but none was given'
            );
        }
        return $arguments;
    }

    protected function doesOutputFormatRequireDestinationFile($output_format)
    {
        return $output_format == 'epub'
            || $output_format == 'odt'
            || $output_format == 'docx';
    }

    /**
     * If the source if a Fileset collection, return the filenames from
     * that collection.
     *
     * @param \phpDocumentor\Fileset\Collection|string[] $source
     *
     * @return string[]
     */
    protected function getFilenames($source)
    {
        if ($source instanceof \phpDocumentor\Fileset\Collection) {
            return array_keys($source->getArrayCopy());
        }

        return $source;
    }

}
