<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Category;
use Mekras\Atom\Node;

/**
 * Support for "atom:category".
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.2
 */
trait Categories
{
    use Base;

    /**
     * Return categories.
     *
     * @return Category[]
     *
     * @throws \InvalidArgumentException
     * @throws \Mekras\Atom\Exception\MalformedNodeException
     *
     * @since 1.0
     */
    public function getCategories()
    {
        return $this->getCachedProperty(
            'categories',
            function () {
                $result = [];
                $nodes = $this->query('atom:category');
                foreach ($nodes as $node) {
                    $result[] = new Category($node);
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
        /** @var Node $this */
        $category = new Category($this);
        $category->setTerm($term);

        return $category;
    }
}
