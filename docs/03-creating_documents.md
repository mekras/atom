# Creating documents

With `DocumentFactory::createDocument()` — you can create new documents from scratch. Supported
document types are:

- `atom:entry` — entry document;
- `atom:feed` — feed document.

## Creating Entry documents

```php
use Mekras\Atom\DocumentFactory;
use Mekras\Atom\Document\EntryDocument;

$factory = new DocumentFactory;

$document = $factory->createDocument('atom::entry');

$entry = $document->getEntry();
$entry->setId('urn:foo:entry:0001');
$entry->setTitle('Entry Title');
$entry->addAuthor('Author 1', 'foo@example.com');
$entry->addAuthor('Author 2', null, 'http://example.com/');
$entry->getContent()->setValue('<h1>Entry content</h1>', 'html');
$entry->addCategory('tag1')->setLabel('Tag label')->setScheme('http://example.com/scheme');

echo (string) $document;
```
## Creating Feed documents

```php
use Mekras\Atom\DocumentFactory;
use Mekras\Atom\Document\FeedDocument;

$factory = new DocumentFactory;

$document = $factory->createDocument('atom:feed');

$feed = $document->getFeed();
$feed->setId('urn:foo:feed:0001');
$feed->setTitle('Feed Title');
$feed->addAuthor('Feed Author')->setEmail('foo@example.com')->setUri('http://example.com/');
$feed->addCategory('tag1')->setScheme('http://example.com/scheme')->setLabel('TAG 1');

$entry = $feed->addEntry();
$entry->setId('urn:foo:entry:0001');
$entry->setTitle('Entry Title');
//...

echo (string) $document;
```
