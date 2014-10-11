<?php namespace Nckg\FeedMe;

use SimpleXMLElement;

class Channel
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $feedUri;

    /**
     * @var string
     */
    protected $websiteUri;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var array
     */
    protected $items = array();

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $feedUri
     * @return $this
     */
    public function setFeedUri($feedUri)
    {
        $this->feedUri = $feedUri;
        return $this;
    }

    /**
     * @param string $websiteUri
     * @return $this
     */
    public function setWebsiteUri($websiteUri)
    {
        $this->websiteUri = $websiteUri;
        return $this;
    }

    /**
     * @param string $language
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Adds a new item to this channel
     *
     * @param Item $item An item
     * @return void
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function asXML()
    {
        $date = new \DateTime('now', new \DateTimeZone('GMT'));
        $nowFormatted = $date->format('D, d M Y H:i:s') . ' GMT';

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?>
			<channel/>
        ', LIBXML_NOERROR|LIBXML_ERR_NONE|LIBXML_ERR_FATAL);

        $xml->addChild('title', $this->title);

        $linkNode = $xml->addChild('link', NULL, 'http://www.w3.org/2005/Atom');
        $linkNode->addAttribute('href', $this->feedUri);
        $linkNode->addAttribute('rel', 'self');
        $linkNode->addAttribute('type', 'application/rss+xml');

        $xml->addChild('link', $this->websiteUri);
        $xml->addChild('description', $this->description);
        $xml->addChild('lastBuildDate', $nowFormatted);
        $xml->addChild('language', $this->language);

        foreach ($this->items as $item) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($item->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, TRUE));
        }

        return $xml;
    }
}