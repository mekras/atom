<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Category;
use Mekras\Atom\Element\Element;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has categories.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.2
 */
trait HasCategories
{
    use NodeInterfaceTrait;

    /**
     * Return categories.
     *
     * @return Category[]
     *
     * @since 1.0
     */
    public function getCategories()
    {
        return $this->getCachedProperty(
            'categories',
            function () {
                $result = [];
                // No REQUIRED — no exception.
                $nodes = $this->query('atom:category');
                foreach ($nodes as $node) {
                    /** @var Element $this */
                    $result[] = $this->getExtensions()->parseElement($this, $node);
                }

                return $result;
            }
        );
    }

    /**
     * Add new entry or feed category.
     *
     * @param string $term
     *
     * @return Category
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function addCategory($term)
    {
        /** @var Category $category */
        $category = $this->addChild('atom:category', 'categories');
        $category->setTerm($term);

        return $category;
    }
}
