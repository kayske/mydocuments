<?php


require_once('YahooAuctionAPI.php');

/**
 * APIAccessBase class
 */
abstract class APIAccessBase
{

    const API_OPTION_APPID       = "appid";
    const API_OPTION_URL         = "url";
    const API_OPTION_PAGE        = "page";
    const API_OPTION_AUCTIONID   = "auctionID";
    // for listing
    const API_OPTION_ESCROW      = "escrow";
    const API_OPTION_EASYPAYMENT = "easypayment";
    const API_OPTION_THUMBNAIL   = "thumbnail";

    const LISTINGS_PER_PAGE      = 50;

    /**
     * private $_api YahooAuctionAPI
     */
    private $_api = null;

    /**
     * protected construct
     * @param $appid ApplicationID
     */
    protected function __construct($appid)
    {
        $this->_api = new YahooAuctionAPI();
        $this->_api->setQuery(self::API_OPTION_APPID, $appid);
    }

    /**
     * protected action
     * @return simplXML object or errorCode 
     */
    protected function action()
    {
        $obj = $this->_api->execute();
        if (!$obj) {
            $obj = $this->_api->getErrorCode();
        }
        return $obj;
    }


    /**
     * protected setOption 
     * @param $key key
     * @param $value value
     */
    protected function setOption($key, $value)
    {
        switch ($key) {
        case self::API_OPTION_URL:
            $this->_api->setUrl($value);
            break;
        default:
            $this->_api->setQuery($key, $value);
            break;
        }
    }

}
?>
