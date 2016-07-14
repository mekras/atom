<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom;

use Mekras\Atom\Document\Document;
use Mekras\Atom\Exception\RuntimeException;

/**
 * Atom Document factory.
 *
 * @since 1.0
 *
 * @api
 */
class DocumentFactory
{
    /**
     * Extensions.
     *
     * @var Extensions
     */
    private $extensions;

    /**
     * Create new factory
     */
    public function __construct()
    {
        $this->extensions = new Extensions();
        $this->extensions->register(new AtomExtension());
    }

    /**
     * Create Atom document from XML DOM document.
     *
     * @param \DOMDocument $document
     *
     * @return Document
     *
     * @throws \InvalidArgumentException If given document is not supported.
     *
     * @since 1.0
     */
    public function parseDocument(\DOMDocument $document)
    {
        $doc = $this->extensions->parseDocument($document);
        if ($doc) {
            return $doc;
        }

        throw new \InvalidArgumentException(
            sprintf('Unexpected root element "%s"', $document->documentElement->localName)
        );
    }

    /**
     * Parse XML and return Atom Document.
     *
     * @param string $xml
     *
     * @return Document
     *
     * @throws \InvalidArgumentException If given document is not supported.
     * @throws \Mekras\Atom\Exception\RuntimeException In case of XML errors.
     *
     * @since 1.0
     */
    public function parseXML($xml)
    {
        $document = new \DOMDocument();

        $previousValue = libxml_use_internal_errors(true);
        libxml_clear_errors();
        $result = $document->loadXML($xml);
        /** @var \libXMLError[] $errors */
        $errors = libxml_get_errors();
        libxml_clear_errors();
        libxml_use_internal_errors($previousValue);

        if (true !== $result) {
            $message = [];
            foreach ($errors as $error) {
                $message[] = sprintf(
                    '%d. [%s] %s in on line %d in position %d',
                    count($message) + 1,
                    $error->code,
                    str_replace(["\n", "\r"], '', $error->message),
                    $error->line,
                    $error->column
                );
            }
            throw new RuntimeException('Can not parse XML: ' . implode('; ', $message));
        }

        return $this->parseDocument($document);
    }

    /**
     * Create new Atom document.
     *
     * @param string $name Document name ("entry", "feed").
     *
     * @return Document
     *
     * @throws \InvalidArgumentException In case of unsupported document name.
     *
     * @since 1.0
     */
    public function createDocument($name)
    {
        $doc = $this->extensions->createDocument($name);
        if ($doc) {
            return $doc;
        }

        throw new \InvalidArgumentException(sprintf('Unknown document "%s"', $name));
    }

    /**
     * Return extension registry.
     *
     * @return Extensions
     *
     * @since 1.0
     */
    public function getExtensions()
    {
        return $this->extensions;
    }
}
