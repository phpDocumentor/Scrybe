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

namespace phpDocumentor\Scrybe\Converter\Metadata;

/**
 * This collection manages which headings were discovered during the discovery
 * phase and stores them as entries.
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
class TableOfContents extends \ArrayObject
{
    /**
     * Returns a hierarchical representation of the entries in this Table of
     * Contents.
     *
     * The basic algorithm is:
     *
     * For each entry:
     * - determine whether the level is
     *   - higher than the previous, if so: add as child.
     *   - equal to the previous, if so: add as sibling
     *   - lower then the previous, if so:
     *     - go up the tree and find the first item that is of rank equal or
     *       lower
     *       - if lower: add as child
     *       - if equal: add as sibling
     *
     * @return TableOfContents\Entry[]
     */
    public function getHierarchical()
    {
        $results = array();
        $current = null;

        /** @var TableOfContents\Entry $entry */
        foreach ($this as $file) {
            foreach ($file as $entry) {
                if (!$current) {
                    $results[] = array(
                        'parent' => null,
                        'entry'  => $entry,
                        'children' => array()
                    );
                    $current = &$results[count($results)-1];
                    continue;
                }

                if ($entry->getLevel() > $current['entry']->getLevel()) {
                    $current['children'][] = array(
                        'parent' => &$current,
                        'entry'  => $entry,
                        'children' => array()
                    );
                    $current = &$current['children'][count($current['children']) -1];
                    continue;
                }

                // move higher up the tree until we have found the same level or
                // have reached the top
                while ($entry->getLevel() < $current['entry']->getLevel()
                    && ($current['parent'] !== null)
                ) {
                    $current = &$current['parent'];
                }

                if ($current['parent'] === null) {
                    // if no parent present; add as root object
                    $results[] = array(
                        'parent' => null,
                        'entry'  => $entry,
                        'children' => array()
                    );
                    $current = &$results[count($results)-1];
                    continue;
                } else {
                    // add as sibling of the current element
                    $current['parent']['children'][] = array(
                        'parent' => &$current['parent'],
                        'entry'  => $entry,
                        'children' => array()
                    );
                    $current = &$current['parent']['children'][
                        count($current['parent']['children']) -1
                    ];
                    continue;
                }
            }
        }

        return $results;
    }
}