# Extending

Atom parsing can be extended via `DocumentFactory::getExtensions()->register()`.

```php
use Mekras\Atom\DocumentFactory;

$factory = new DocumentFactory;
$factory->getExtensions()->register(new FooExtension());
//...
```

## New document types

**FooDocumentExtension.php**

```php
use Mekras\Atom\Extension\DocumentExtension;

class FooDocumentExtension implements Extension
{
    public function parseDocument(Extensions $extensions, \DOMDocument $document)
    {
        if ('Foo NS' === $document->documentElement->namespaceURI) {
            switch ($document->documentElement->localName) {
                case 'foo':
                    return new FooDocument($extensions, $document);
            }
        }

        return null;
    }

    public function createDocument(Extensions $extensions, $name)
    {
            switch ($name) {
                case 'foo:document':
                    return new FooDocument($extensions);
            }
        }

        return null;
    }
}
```

## Internal API

TODO
