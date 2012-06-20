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

namespace phpDocumentor\Scrybe\Template;

class Twig implements TemplateInterface
{
    protected $extension = 'html';
    protected $name = 'default';
    protected $path = '';

    /**
     * Constructs the twig template and sets the default values.
     */
    function __construct()
    {
        $this->path = realpath(__DIR__ . '/../../../../data/templates/');
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function decorate($contents, array $options = array())
    {
        return $this->getTwigEnvironment()->render(
            $this->getTemplateFilename(),
            array_merge( array('contents' => $contents), $options )
        );
    }

    protected function getTemplateFilename()
    {
        $filename = $this->name.'/layout.' . $this->extension . '.twig';

        $template_path = $this->path . DIRECTORY_SEPARATOR . $filename;
        if (!file_exists($template_path)) {
            throw new \DomainException(
                'Template file "' . $template_path . '" could not be found'
            );
        }

        return $filename;
    }

    protected function getTwigEnvironment()
    {
        $twig = new \Twig_Environment(new \Twig_Loader_Filesystem($this->path));

        // we explicitly do not want to escape content; all escaping has been
        // handled by the converter itself
        $twig->removeExtension('escaper');

        return $twig;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function getExtension()
    {
        return $this->extension;
    }
}
