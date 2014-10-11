<?php

use Nckg\FeedMe\Channel;
use Nckg\FeedMe\FeedMe;
use Nckg\FeedMe\Item;

class FeedMeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Nckg\FeedMe\FeedMe
     */
    protected $object;

    /**
     * Setup for each test
     */
    public function setUp()
    {
        date_default_timezone_set('Europe/Brussels');
        $this->object = new FeedMe;
    }

    public function testCanRenderFeed()
    {
        $date = new \DateTime('now', new \DateTimeZone('GMT'));
        $nowFormatted = $date->format('D, d M Y H:i:s') . ' GMT';

        // Arrange
        $expected = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:default="http://www.w3.org/2005/Atom" version="2.0">
  <channel xmlns:default="http://www.w3.org/2005/Atom">
    <title>An RSS channel</title>
    <default:link xmlns="http://www.w3.org/2005/Atom" href="http://www.w3.org" rel="self" type="application/rss+xml"/>
    <link>http://github.com/nckg/feedme</link>
    <description>My RSS channel</description>
    <lastBuildDate>{$nowFormatted}</lastBuildDate>
    <language>nl-BE</language>
    <item>
      <guid isPermaLink="false"/>
      <title>My first blog post</title>
      <link/>
      <pubDate>{$nowFormatted}</pubDate>
      <description><![CDATA[Foobar]]></description>
    </item>
  </channel>
</rss>

XML;
        $channel = new Channel();
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
        $this->object->addChannel($channel);

        // Act
        // Assert
        $this->assertEquals($expected, $this->object->render());
    }
}