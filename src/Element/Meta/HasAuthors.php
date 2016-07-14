<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Author;
use Mekras\Atom\Element\Element;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has authors.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.1
 */
trait HasAuthors
{
    use NodeInterfaceTrait;

    /**
     * Return authors.
     *
     * @return Author[]
     *
     * @since 1.0
     */
    public function getAuthors()
    {
        return $this->getCachedProperty(
            'authors',
            function () {
                $result = [];
                // No REQUIRED — no exception.
                $nodes = $this->query('atom:author');
                foreach ($nodes as $node) {
                    /** @var Element $this */
                    $result[] = $this->getExtensions()->parseElement($this, $node);
                }

                return $result;
            }
        );
    }

    /**
     * Add new entry or feed author.
     *
     * @param string $name
     *
     * @return Author
     *
     * @since 1.0
     */
    public function addAuthor($name)
    {
        /** @var Author $author */
        $author = $this->addChild('atom:author', 'authors');
        $author->setName($name);

        return $author;
    }
}
