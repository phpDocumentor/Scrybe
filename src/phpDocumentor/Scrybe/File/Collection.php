<?php
namespace phpDocumentor\Scrybe\File;

use \phpDocumentor\Scrybe\File\File;

class Collection extends \ArrayObject
{
    protected $project_root = null;

    public function offsetSet($index, $newval)
    {
        if (!$newval instanceof File) {
            throw new \InvalidArgumentException(
                'Expected item in file collection to be of type File'
            );
        }
        parent::offsetSet($index, $newval);
    }

    public function addFromFinder(\Symfony\Component\Finder\Finder $finder)
    {
        try {
            /** @var \SplFileInfo $file */
            foreach ($finder as $file) {
                $this[] = new File($file->getRealPath());
            }
        } catch(\LogicException $e) {
            // Logic Exceptions are only thrown when no content has been added
            // to the Finder, we do not care about that and just do not add
            // content to the collection
        }
    }

    /**
     * Calculates the project root from the given files by determining their
     * highest common path.
     *
     * @return string
     */
    public function getProjectRoot()
    {
        if ($this->project_root === null) {
            $base = '';
            $file = reset($this);

            // realpath does not work on phar files
            $file = (substr($file, 0, 7) != 'phar://')
                ? realpath($file)
                : $file;

            $parts = explode(DIRECTORY_SEPARATOR, $file);

            foreach ($parts as $part) {
                $base_part = $base . $part . DIRECTORY_SEPARATOR;
                foreach ($this as $dir) {

                    // realpath does not work on phar files
                    $dir = (substr($dir, 0, 7) != 'phar://')
                            ? realpath($dir)
                            : $dir;

                    if (substr($dir, 0, strlen($base_part)) != $base_part) {
                        $this->project_root = $base;
                        return $base;
                    }
                }

                $base = $base_part;
            }

            $this->project_root = $base;
        }

        return $this->project_root;
    }

}
