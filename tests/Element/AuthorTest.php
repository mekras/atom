<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Element\Author;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Element\Author
 */
class AuthorTest extends TestCase
{
    /**
     *
     */
    public function testBasics()
    {
        $doc = $this->createDocument(
            '<name>Foo</name><email> foo@example.com</email><uri>http://example.com/ </uri>'
        );

        $person = new Author($this->createFakeNode(), $doc->documentElement);
        static::assertEquals('Foo', $person->getName());
        static::assertEquals('Foo', (string) $person);
        static::assertEquals('foo@example.com', $person->getEmail());
        static::assertEquals('http://example.com/', $person->getUri());
    }

    /**
     * __toString should return an empty string in case of error.
     */
    public function testRenderError()
    {
        $doc = $this->createDocument();
        $person = new Author($this->createFakeNode(), $doc->documentElement);
        static::assertEquals('', (string) $person);
    }
}
