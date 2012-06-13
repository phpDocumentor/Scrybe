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

namespace phpDocumentor\Scrybe\Converter\RestructuredText\Directives;

use \phpDocumentor\Scrybe\Converter\RestructuredText\Visitors\Discover;

class Figure extends \ezcDocumentRstFigureDirective
{
    /** @var Discover */
    protected $visitor;

    /**
     * Converts the Image directive to aDocBook image tag.
     *
     * This method takes an image directive and converts it into its DocBook
     * representation and stores a reference in the Asset manager of the
     * Converter.
     *
     * @see ConverterInterface::getAssets() for the asset manager
     *
     * @param \DOMDocument $document
     * @param \DOMElement $root
     *
     * @return void
     */
    public function toDocbook(\DOMDocument $document, \DOMElement $root)
    {
        $this->storeAsset();
        parent::toDocbook($document, $root);
    }

    /**
     * Converts the Image directive to an <img/> tag.
     *
     * This method takes an image directive and converts it into its HTML
     * representation and stores a reference in the Asset manager of the
     * Converter.
     *
     * @see ConverterInterface::getAssets() for the asset manager
     *
     * @param \DOMDocument $document
     * @param \DOMElement $root
     *
     * @return void
     */
    public function toXhtml(\DOMDocument $document, \DOMElement $root)
    {
        $this->storeAsset();
        parent::toXhtml($document, $root);
    }

    /**
     * Stores the asset in the asset manager.
     *
     * This method takes an asset defined in the directive and stores that in
     * the asset manager.
     *
     * The following rules apply:
     *
     * 1. The source of the asset is the relative path of the asset prefixed
     *    with a path based on the following rules:
     *
     *    1. If the asset starts with a slash then the path is calculated from
     *       the project's root or
     *    2. if the asset does not start with a slash then the path is
     *       calculated from the file's directory.
     *
     * 2. the destination of the asset is the path relative to the project root.
     *
     *    1. When the asset starts with a slash then this equals that path
     *       without the leading slash.
     *    2. If not, the destination must be calculated by subtracting the
     *       project root from the current file's path and prepending that to
     *       the asset path (resolving `../` patterns in the mean time).
     *
     * @return void
     */
    protected function storeAsset()
    {
        if (!$this->visitor instanceof Discover)
        {
            return;
        }

        $assets       = $this->getAssetManager();
        $project_root = $assets->getProjectRoot();
        $asset_path   = trim($this->node->parameters);
        $file_path    = $this->visitor->getDocument()->getFile()->getRealPath();

        // get source path
        if ($asset_path[0] !== '/') {
            $source = dirname($file_path) . '/' . $asset_path;
        } else {
            $source = $project_root . $asset_path;
        }

        // get destination path
        if ($asset_path[0] !== '/') {
            $destination = substr(
                dirname($file_path).'/'.$asset_path, strlen($project_root)
            );
        } else {
            $destination = substr($asset_path, 1);
        }

        // set asset
        $assets->set($source, $destination);
    }

    /**
     * Returns the asset manager.
     *
     * @return \phpDocumentor\Scrybe\Converter\Metadata\Assets
     */
    protected function getAssetManager()
    {
        return $this->visitor->getDocument()->getConverter()->getAssets();
    }
}