<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Contributor;
use Mekras\Atom\Element\Element;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has contributors.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.3
 */
trait HasContributors
{
    use NodeInterfaceTrait;

    /**
     * Return contributors.
     *
     * @return Contributor[]
     *
     * @since 1.0
     */
    public function getContributors()
    {
        return $this->getCachedProperty(
            'contributors',
            function () {
                $result = [];
                // No REQUIRED — no exception.
                $nodes = $this->query('atom:contributor');
                foreach ($nodes as $node) {
                    /** @var Element $this */
                    $result[] = $this->getExtensions()->parseElement($this, $node);
                }

                return $result;
            }
        );
    }

    /**
     * Add new contributor.
     *
     * @param string $name
     *
     * @return Contributor
     *
     * @since 1.0
     */
    public function addContributor($name)
    {
        /** @var Contributor $contributor */
        $contributor = $this->addChild('atom:contributor', 'contributors');
        $contributor->setName($name);

        return $contributor;
    }
}
