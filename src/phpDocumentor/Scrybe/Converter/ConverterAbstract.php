<?php
namespace phpDocumentor\Scrybe\Converter;

use \phpDocumentor\Scrybe;
use \phpDocumentor\Scrybe\File\File;

abstract class ConverterAbstract
{
    protected $destination_root = 'docs';

    /**
     * @param \phpDocumentor\Scrybe\File\Collection $filenames_argument
     *
     * @return \phpDocumentor\Scrybe\File\Collection
     */
    public function execute(Scrybe\File\Collection $files)
    {
        $result = new Scrybe\File\Collection();

        /** @var \phpDocumentor\Scrybe\File\File $file */
        foreach ($files as $file) {
            $destination_filename = $this->getDestinationFilename(
                $files->getProjectRoot(), $file->getPathname()
            );
            $this->createDirectoryIfMissing(dirname($destination_filename));

            $result[] = $this->createDestinationFile(
                $destination_filename, $this->applyTemplate($this->convert($file))
            );
        }

        return $result;
    }

    public function getDestinationFilename($project_root, $source_path)
    {
        $path = $this->getDestinationRoot() . DIRECTORY_SEPARATOR
            . substr($source_path, strlen($project_root));

        return substr($path, 0, strrpos($path, '.')) . '.' . $this->getExtension();
    }

    protected function createDirectoryIfMissing($directory)
    {
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        if (!is_dir($directory)) {
            throw new \RuntimeException(
                'Unable to create directory, "'. $directory.'" already '
                .'exists as file'
            );
        }
    }

    protected function createDestinationFile($filename, $contents)
    {
        $converted_file = new File($filename);
        $converted_file->ftruncate(0);
        $converted_file->fwrite($contents);

        return $converted_file;
    }

    public function setDestinationRoot($destination_root)
    {
        $this->destination_root = $destination_root;
    }

    public function getDestinationRoot()
    {
        return $this->destination_root;
    }

    protected function applyTemplate($contents, array $options = array())
    {
        if (!$this instanceof Templateable) {
            return $contents;
        }

        $template_path     = __DIR__ . '/../../../../data/templates';
        $template_filename = 'layout.' . $this->getExtension() . '.twig';

        if (!file_exists($template_path.'/'.$template_filename)) {
            throw new \DomainException(
                'Template file "'. $template_path . '/' . $template_filename
                .'" could not be found'
            );
        }

        $twig = new \Twig_Environment(
            new \Twig_Loader_Filesystem($template_path)
        );

        // we explicitly do not want to escape content; all escaping has been
        // handled by the converter itself
        $twig->removeExtension('escaper');

        return $twig->render(
            $template_filename,
            array_merge(
                array('contents' => $contents),
                $options
            )
        );
    }

    abstract public function getSourceExtension();
    abstract public function getExtension();
    abstract protected function convert(File $file);
}
