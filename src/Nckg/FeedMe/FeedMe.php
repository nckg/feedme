<?php namespace Nckg\FeedMe;

class FeedMe
{

    protected $channels = array();

    /**
     * Adds a new channel to this feed
     *
     * @param Channel $channel
     * @return Feed
     */
    public function addChannel(Channel $channel)
    {
        $this->channels[] = $channel;
        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?>
            <rss version="2.0" />
        ', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        foreach ($this->channels as $channel) {
            /** @var Channel $channel */
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($channel->asXml());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        $domDocument = new \DOMDocument('1.0', 'UTF-8');
        $domDocument->appendChild($domDocument->importNode(dom_import_simplexml($xml), true));
        $domDocument->formatOutput = true;
        return $domDocument->saveXML();
    }
}