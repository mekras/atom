<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Atom;
use Mekras\Atom\Element\Category;

/**
 * Support for "app:category".
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
     * @param string      $term
     * @param string|null $label
     * @param string|null $scheme IRI
     *
     * @since 1.0
     */
    public function addCategory($term, $label = null, $scheme = null)
    {
        $document = $this->getDomElement()->ownerDocument;
        $category = $document->createElementNS(Atom::NS, 'category');
        $this->getDomElement()->appendChild($category);

        $category->setAttribute('term', $term);

        if ($label) {
            $category->setAttribute('label', $label);
        }

        if ($scheme) {
            $category->setAttribute('scheme', $scheme);
        }
    }
}
