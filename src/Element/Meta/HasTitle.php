<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Title;
use Mekras\Atom\Exception\MalformedNodeException;
use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has a title.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.14
 */
trait HasTitle
{
    use NodeInterfaceTrait;

    /**
     * Return title.
     *
     * @return Title
     *
     * @throws \InvalidArgumentException
     * @throws \Mekras\Atom\Exception\MalformedNodeException
     *
     * @since 1.0
     */
    public function getTitle()
    {
        return $this->getCachedProperty(
            'title',
            function () {
                $element = $this->query('atom:title', Node::SINGLE | Node::REQUIRED);

                /** @var Element $this */
                return $this->getExtensions()->parseElement($this, $element);
            }
        );
    }

    /**
     * Set title.
     *
     * @param string $value
     * @param string $type
     *
     * @since 1.0
     *
     * @throws \InvalidArgumentException
     */
    public function setTitle($value, $type = 'text')
    {
        try {
            $title = $this->getTitle();
        } catch (MalformedNodeException $e) {
            /** @var Element $this */
            /** @var Title $title */
            $title = $this->getExtensions()->createElement($this, 'atom:title');
        }
        $title->setValue($value, $type);
        $this->setCachedProperty('title', $title);
    }
}
