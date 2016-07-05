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
 * "atom:category" construct
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.2
 */
class Category extends Element
{
    /**
     * Return category name.
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     * @throws \Mekras\Atom\Exception\MalformedNodeException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.2.1
     */
    public function getTerm()
    {
        return $this->getCachedProperty(
            'term',
            function () {
                if (!$this->getDomElement()->hasAttribute('term')) {
                    throw new MalformedNodeException('There is no attribute "term"');
                }

                return $this->getDomElement()->getAttribute('term');
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
        $this->getDomElement()->setAttribute('term', $value);
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
                if (!$this->getDomElement()->hasAttribute('label')) {
                    return null;
                }

                return $this->getDomElement()->getAttribute('label');
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
        $this->getDomElement()->setAttribute('label', $value);
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
                if (!$this->getDomElement()->hasAttribute('scheme')) {
                    return null;
                }

                return $this->getDomElement()->getAttribute('scheme');
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
        $this->getDomElement()->setAttribute('scheme', $value);
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
