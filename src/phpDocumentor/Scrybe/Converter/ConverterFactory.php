<?php

namespace phpDocumentor\Scrybe\Converter;

/**
 * This factory attempts to find a converter given an input and output format
 * and return that.
 *
 * <code>
 *     $converter = ConverterFactory::get(
 *         ConverterFactory::MARKDOWN, ConverterFactory::HTML
 *     );
 * <code>
 *
 * @author Mike van Riel <mike.vanriel@naenius.com>
 */
class ConverterFactory
{
    const MARKDOWN = 'markdown';
    const JSON     = 'json';
    const RST      = 'rst';
    const TEXTILE  = 'textile';
    const HTML     = 'html';
    const LATEX    = 'latex';
    const PDF      = 'pdf';

    /** @var ConverterAbstract[] a list of all available converters */
    static protected $converters = array();

    /**
     * Adds a converter to the system.
     *
     * @param string            $input_type
     * @param string            $output_type
     * @param ConverterAbstract $converter
     *
     * @return void
     */
    public static function add($input_type, $output_type, $converter)
    {
        if (!isset(self::$converters[$input_type])) {
            self::$converters[$input_type] = array();
        }

        if (!isset(self::$converters[$input_type][$output_type])) {
            self::$converters[$input_type][$output_type] = array();
        }

        self::$converters[$input_type][$output_type] = $converter;
    }

    /**
     * Returns the first converter for a given input and output type that is
     * available given the system specifications.
     *
     * @param string $input_type
     * @param string $output_type
     *
     * @throws \InvalidArgumentException
     *
     * @return ConverterAbstract
     */
    public static function get($input_type, $output_type)
    {
        if (!self::$converters) {
            self::registerDefaultConverters();
        }

        if (isset(self::$converters[$input_type][$output_type])) {
            return self::$converters[$input_type][$output_type];
        }

        // nothing was found
        throw new \InvalidArgumentException(
            'No converter found to convert from ' .$input_type.' to '.$output_type
        );
    }

    /**
     * Returns a list of supported input formats.
     *
     * @return string[]
     */
    public static function getSupportedInputFormats()
    {
        return array(
            self::MARKDOWN
        );
    }

    /**
     * Returns a list of supported output formats.
     *
     * @return string[]
     */
    public static function getSupportedOutputFormats()
    {
        return array(
            self::HTML
        );
    }

    /**
     * Registers the converters that are included by default in this library.
     *
     * @return void
     */
    protected static function registerDefaultConverters()
    {
        self::add(self::MARKDOWN, self::HTML,  new Markdown2Html());
        self::add(self::MARKDOWN, self::LATEX, new Markdown2Latex());
        self::add(self::MARKDOWN, self::PDF,   new Markdown2Pdf());
        self::add(self::RST,      self::LATEX, new ReST2Latex());
        self::add(self::RST,      self::PDF,   new ReST2Pdf());
    }

}