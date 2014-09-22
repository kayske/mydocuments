<?php


require_once('common/APIAccessBase.php');

/**
 * AuctionItem class
 */
class AuctionItem extends APIAccessBase
{

    /**
     * url for access
     */
    const AUCTION_API_URL = 'http://auctions.yahooapis.jp/AuctionWebService/';

    /**
     * api name
     */
    const API_NAME = 'auctionItem';

    /**
     * api version
     */
    private $_version = null;

    /**
     * public construct
     * @param $appid ApplicationID
     */
    public function __construct($appid, $version)
    {
        parent::__construct($appid);
        $this->_version = $version;
    }

    /**
     * public action
     * @return simplXML object or errorCode
     */
    public function action()
    {
        parent::setOption(parent::API_OPTION_URL, self::AUCTION_API_URL . $this->_version . "/" . self::API_NAME);
        return parent::action();
    }

    /**
     * public setOption
     * @param $key key
     * @param $value value
     */
    public function setOption($key, $value)
    {
        parent::setOption($key, $value);
    }

}
?>
