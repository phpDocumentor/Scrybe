<?php

namespace phpDocumentor\Scrybe\File;

/**
 * Class representing a single file.
 */
class File extends \SplFileObject
{
    /**
     * Open file for reading and writing, and if it doesn't exist create it.
     *
     * @param string $filename
     */
    public function __construct($filename)
    {
        parent::__construct($filename, 'a+', false);
    }

    /**
     * Returns the mime type for this file.
     *
     * @throws \RuntimeException if finfo failed to load and/or mim_content_type
     *   is unavailable
     * @throws \LogicException if the mime type could not be interpreted from
     *   the output of finfo_file
     *
     * @return string
     */
    public function getMimeType()
    {
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            if (!$finfo) {
                throw new \RuntimeException('Failed to open finfo');
            }

            $mime = strtolower(finfo_file($finfo, $this->getPathname()));
            finfo_close($finfo);

            if (!preg_match(
                '/^([a-z0-9]+\/[a-z0-9\-\.]+);\s+charset=(.*)$/', $mime, $matches
            )) {
                throw new \LogicException(
                    'An error parsing the MIME type "'.$mime.'".'
                );
            }

            return $matches[1];
        } elseif (function_exists('mime_content_type')) {
            return mime_content_type($this->getPathname());
        }

        throw new \RuntimeException(
            'The finfo extension or mime_content_type function are needed to '
            .'determine the Mime Type for this file.'
        );
    }

    /**
     * Returns the file contents as a string.
     *
     * @return string
     */
    public function fread()
    {
        $result = '';
        foreach ($this as $line) {
            $result .= $line;
        }
        return $result;
    }
}
