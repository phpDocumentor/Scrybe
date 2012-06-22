<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @author    Mike van Riel <mike.vanriel@naenius.com>
 * @copyright 2012 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Scrybe\Template;

/**
 * A factory used to retrieve a template engine given a simplified name.
 *
 * With this factory it is possible to abstract away the actual class names and
 * provide a faux name that is suitable for configuration purposes.
 * An additional benefit is that any plugin is able to register their own
 * template engines if desired.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
class Factory
{
    /**
     * @var string[] Associative array with engine names as key and class names
     *     as value.
     */
    protected $engines = array();

    /**
     * Registers the default and provided Template engines.
     */
    public function __construct(array $engines = array())
    {
        $this->register('twig', 'phpDocumentor\Scrybe\Template\Twig');

        foreach($engines as $name => $class) {
            $this->register($name, $class);
        }
    }

    /**
     * Associates a human-readable / simplified name with a class name
     * representing a template engine.
     *
     * The class belonging to the given class name should implement the
     * TemplateInterface. If it does not then this method won't complain
     * (as no instantiation is done here for performance reasons) but the
     * `get()` method will throw an exception.
     *
     * @param string $name
     * @param string $class_name
     *
     * @throws \InvalidArgumentException if either name or class_name is not
     *     a string
     *
     * @see get() to retrieve an instance for the given $name.
     *
     * @return void
     */
    public function register($name, $class_name)
    {
        if (!is_string($name) || !is_string($class_name)) {
            throw new \InvalidArgumentException(
                'Both the name and class name must be strings'
            );
        }

        $this->engines[$name] = $class_name;
    }

    /**
     * Returns a new instance of the template engine belonging to the given name.
     *
     * @param string $name
     *
     * @throws \InvalidArgumentException if the given name is not registered
     * @throws \RuntimeException if the class belonging to the $name does not
     *     implement the TemplateInterface class.
     *
     * @return TemplateInterface
     */
    public function get($name)
    {
        if (!isset($this->engines[$name])) {
            throw new \InvalidArgumentException(
                'Template engine "'.$name.'" is not known or registered'
            );
        }

        $class_name = $this->engines[$name];

        /** @var TemplateInterface $template  */
        $template = new $class_name();
        if (!$template instanceof TemplateInterface) {
            throw new \RuntimeException(
                'Unable to use "'.$class_name.'" for templates. It does not '
                .'implement TemplateInterface'
            );
        }

        return $template;
    }
}
