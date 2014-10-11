<?php
namespace Nckg\FeedMe;
use SimpleXMLElement;

/**
 * An item of an RSS channel
 */
class Item
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $itemLink;

    /**
     * @var string
     */
    protected $commentsLink;

    /**
     * @var \DateTime
     */
    protected $publicationDate;

    /**
     * @var string
     */
    protected $guid;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array<string>
     */
    protected $categories = array();

    /**
     * @param array $categories
     * @return $this
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param string $commentsLink
     * @return $this
     */
    public function setCommentsLink($commentsLink)
    {
        $this->commentsLink = $commentsLink;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommentsLink()
    {
        return $this->commentsLink;
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $guid
     * @return $this
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;
        return $this;
    }

    /**
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @param string $itemLink
     * @return $this
     */
    public function setItemLink($itemLink)
    {
        $this->itemLink = $itemLink;
        return $this;
    }

    /**
     * @return string
     */
    public function getItemLink()
    {
        return $this->itemLink;
    }

    /**
     * @param \DateTime $publicationDate
     * @return $this
     */
    public function setPublicationDate(\DateTime $publicationDate = NULL)
    {
        $this->publicationDate = $publicationDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function asXml()
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?>
			<item/>', LIBXML_NOERROR|LIBXML_ERR_NONE|LIBXML_ERR_FATAL);

        $node = $xml->addChild('guid', $this->guid);
        $node->addAttribute('isPermaLink', 'false');

        $xml->addChild('title', $this->title);
        $xml->addChild('link', $this->itemLink);

        if ($this->commentsLink !== null) {
            $xml->addChild('comments', $this->commentsLink);
        }

        if ($this->publicationDate !== null) {
            $xml->addChild('pubDate', $this->publicationDate->format('D, d M Y H:i:s') . ' GMT');
        }

        if ($this->description !== null) {
            $child = $xml->addChild('description');
            $node = dom_import_simplexml($child);

            $node->appendChild($node->ownerDocument->createCDATASection($this->description));
        }

        return $xml;
    }

}