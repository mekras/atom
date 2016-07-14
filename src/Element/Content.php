<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

use Mekras\Atom\Exception\MalformedNodeException;
use Mekras\Atom\Node;
use Mekras\Atom\Util\Xhtml;

/**
 * "atom:content" element.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.1.3
 */
class Content extends Element
{
    /**
     * Represent content as a string.
     *
     * @return string
     *
     * @since 1.0
     */
    public function __toString()
    {
        try {
            return $this->getContent();
        } catch (MalformedNodeException $e) {
            return '(' . $e->getMessage() . ')';
        }
    }

    /**
     * Return content
     *
     * @return string
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException If there is no required element.
     *
     * @since 1.0
     *
     * @link  https://tools.ietf.org/html/rfc4287#section-4.1.3.3
     */
    public function getContent()
    {
        return $this->getCachedProperty(
            'content',
            function () {
                $type = $this->getType();
                if ('text' === $type || 'html' === $type) {
                    return $this->getDomElement()->textContent;
                } elseif ('xhtml' === $type) {
                    /** @var \DOMElement $xhtml */
                    $xhtml = $this->query('xhtml:div', Node::SINGLE | Node::REQUIRED);

                    return Xhtml::extract($xhtml);
                } elseif ($this->isXmlMimeType($type)) {
                    /** @var \DOMElement $xml */
                    $xml = $this->query('*', Node::SINGLE | Node::REQUIRED);

                    return $this->getDomElement()->ownerDocument->saveXML($xml);
                } elseif (stripos($type, 'text/') === 0) {
                    return $this->getDomElement()->textContent;
                }

                return base64_decode($this->getDomElement()->textContent);
            }
        );
    }

    /**
     * Set new content.
     *
     * For "text" and "html" $type values $content should be a string.
     *
     * For "xhtml" and all XML-based $type values $content should be an instance of
     * @{link DOMElement}.
     *
     * In all other cases $content should be a binary string and it will be base64 encoded.
     *
     * When $type is "xhtml" child nodes of $content will be moved to "xhtml:div" container.
     *
     * @param string|\DOMElement $content
     * @param string             $type
     *
     * @throws \InvalidArgumentException If $content type does not match given $type.
     *
     * @since 1.0
     */
    public function setContent($content, $type = 'text')
    {
        $type = (string) $type;
        $this->setType($type);
        $document = $this->getDomElement()->ownerDocument;

        if ('text' === $type || 'html' === $type) {
            $this->getDomElement()->nodeValue = (string) $content;
        } elseif ('xhtml' === $type) {
            if (!$content instanceof \DOMElement) {
                throw new \InvalidArgumentException('Content should be an instance of DOMElement');
            }
            Xhtml::import($content, $this->getDomElement());
        } elseif ($this->isXmlMimeType($type)) {
            if (!$content instanceof \DOMElement) {
                throw new \InvalidArgumentException('Content should be an instance of DOMElement');
            }
            $this->getDomElement()->appendChild($document->importNode($content, true));
        } elseif (stripos($type, 'text/') === 0) {
            $this->getDomElement()->nodeValue = (string) $content;
        } else {
            $this->getDomElement()->nodeValue = base64_encode($content);
        }
        $this->setCachedProperty('content', $content);
    }

    /**
     * Return content type.
     *
     * @return string "text", "html", "xhtml" or MIME type.
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.1.3.1
     */
    public function getType()
    {
        // No NS prefix — no exception.
        return $this->getAttribute('type') ?: 'text';
    }

    /**
     * Set content type.
     *
     * @param string $type "text", "html", "xhtml" or MIME type.
     *
     * @return $this
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.1.3.1
     */
    public function setType($type)
    {
        // No NS prefix — no exception.
        $this->setAttribute('type', $type);

        return $this;
    }

    /**
     * Return content IRI.
     *
     * @return string|null
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.1.3.2
     */
    public function getSrc()
    {
        // No NS prefix — no exception.
        return $this->getAttribute('src');
    }

    /**
     * Set content IRI.
     *
     * @param string|null $iri
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.1.3.2
     */
    public function setSrc($iri)
    {
        // No NS prefix — no exception.
        $this->setAttribute('src', $iri);
    }

    /**
     * Return node name here.
     *
     * @return string
     *
     * @since 1.0
     */
    protected function getNodeName()
    {
        return 'content';
    }

    /**
     * Return TRUE if $type is one of the XML MIME types.
     *
     * @param string $type
     *
     * @return bool
     */
    private function isXmlMimeType($type)
    {
        return (bool) preg_match('~^([\w-]+)/((xml.*)|(.+\+xml))$~', $type);
    }
}
