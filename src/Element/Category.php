<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

use Mekras\Atom\Exception\MalformedNodeException;

/**
 * "atom:category" element
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.2
 */
class Category extends Element
{
    /**
     * Return category as a string.
     *
     * @return string
     *
     * @since 1.1
     */
    public function __toString()
    {
        try {
            return (string) $this->getTerm();
        } catch (\Exception $e) {
            return '(empty)';
        }
    }

    /**
     * Return category name.
     *
     * @return string
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException If there is no required attribute.
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.2.1
     */
    public function getTerm()
    {
        return $this->getCachedProperty(
            'term',
            function () {
                // No NS prefix — no exception.
                $value = $this->getAttribute('term');
                if (null === $value) {
                    throw new MalformedNodeException('There is no required attribute "term"');
                }

                return $value;
            }
        );
    }

    /**
     * Set category name.
     *
     * @param string $value
     *
     * @return $this
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.2.1
     */
    public function setTerm($value)
    {
        // No NS prefix — no exception.
        $this->setAttribute('term', $value);
        $this->setCachedProperty('term', $value);

        return $this;
    }

    /**
     * Return human readable label.
     *
     * @return string|null
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.2.3
     */
    public function getLabel()
    {
        return $this->getCachedProperty(
            'label',
            function () {
                // No NS prefix — no exception.
                return $this->getAttribute('label');
            }
        );
    }

    /**
     * Set human readable label.
     *
     * @param string $value
     *
     * @return $this
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.2.3
     */
    public function setLabel($value)
    {
        // No NS prefix — no exception.
        $this->setAttribute('label', $value);
        $this->setCachedProperty('label', $value);

        return $this;
    }

    /**
     * Return category scheme.
     *
     * @return string IRI
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.2.2
     */
    public function getScheme()
    {
        return $this->getCachedProperty(
            'scheme',
            function () {
                // No NS prefix — no exception.
                return $this->getAttribute('scheme');
            }
        );
    }

    /**
     * Set category scheme.
     *
     * @param string $value
     *
     * @return $this
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.2.2
     */
    public function setScheme($value)
    {
        // No NS prefix — no exception.
        $this->setAttribute('scheme', $value);
        $this->setCachedProperty('scheme', $value);

        return $this;
    }

    /**
     * Return node name.
     *
     * @return string
     *
     * @since 1.0
     */
    protected function getNodeName()
    {
        return 'category';
    }
}
