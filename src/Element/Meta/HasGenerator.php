<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Generator;
use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has an generator.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.4
 */
trait HasGenerator
{
    use NodeInterfaceTrait;

    /**
     * Return generator.
     *
     * @return Generator|null
     *
     * @since 1.0
     */
    public function getGenerator()
    {
        return $this->getCachedProperty(
            'generator',
            function () {
                // No REQUIRED — no exception.
                $element = $this->query('atom:generator', Node::SINGLE);

                /** @var Element $this */
                return $element ? $this->getExtensions()->parseElement($this, $element) : null;
            }
        );
    }

    /**
     * Add generator.
     *
     * @param string $generator Generator name.
     *
     * @return Generator
     *
     * @since 1.0
     */
    public function addGenerator($generator)
    {
        /** @var Generator $element */
        $element = $this->addChild('atom:generator', 'generator');
        $element->setContent($generator);

        return $element;
    }
}
