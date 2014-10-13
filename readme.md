# Feed Me
[![Build Status](https://travis-ci.org/nckg/feedme.svg?branch=master)](https://travis-ci.org/nckg/feedme)

## Installation
Simply add a dependency on `nckg/feedme` to your project's composer.json file if you use Composer to manage the dependencies of your project.

```
{
    "require-dev": {
        "nckg/feedme": "dev-master"
    }
}
```

## Usage

```php
    $feed = new Feed;
    $channel = new Channel;
    $channel
        ->setTitle('An RSS channel')
        ->setFeedUri('http://www.w3.org')
        ->setWebsiteUri('http://github.com/nckg/feedme')
        ->setDescription('My RSS channel')
        ->setLanguage('nl-BE');

    $item = new Item();
    $item
        ->setTitle('My first blog post')
        ->setPublicationDate($date)
        ->setDescription('Foobar');

    $channel->addItem($item);
    $feed->addChannel($channel);
    echo $feed->render();
```

### License

[MIT license](http://opensource.org/licenses/MIT)
