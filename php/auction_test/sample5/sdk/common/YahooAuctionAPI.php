<?php


/**
 * YahooAuctionAPI class
 */
class YahooAuctionAPI
{

    /**
     * private $_url Request URL 
     */
    private $_url = "";

    /**
     * private $_method httpmethod
     */
    private $_method = "GET";

    /**
     * private $_timeout time out
     */
    private $_timeout = "30";

    /**
     * private $_queryArray Request Query 
     */
    private $_queryArray = array();

    /**
     * private $_errorCode curl error code
     */
    private $_errorCode = "";

    /**
     * private $_userAgent UserAgent
     */
    private $_userAgent = "auction-api-developer";

    /**
     * construct
     */
    public function __construct()
    {
    }

    /**
     * public setUrl 
     * @param $url 
     * @return 
     */
    public function setUrl($url)
    {
        $this->_url = $url;
    }

    /**
     * public setMethod
     * @param $method http method
     * @return 
     */
    public function setMethod($method)
    {
        $this->_method = $method;
    }

    /**
     * public setQuery 
     * @param $key key
     * @param $value value
     * @return
     */
    public function setQuery($key, $value)
    {
        $this->_queryArray[$key] = $value;
    }

    /**
     * public setTimeout
     * @param $timeout
     * @return 
     */
    public function setTimeout($timeout)
    {
        $this->_timeout = $timeout;
    }

    /**
     * public getErrorCode
     * @return $_errorCode
     */
    public function getErrorCode()
    {
        return $this->_errorCode;
    }

    /**
     * public execute 
     * @return Response / false
     */
    public function execute()
    {

        // init curl
        $ch = curl_init();

        // set parameters
        $parameters = $this->_makeParameter();

        // curl option
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->_userAgent);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);

        // select method
        switch ($this->_method) {
        case "GET":
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            if ($parameters) {
                curl_setopt($ch, CURLOPT_URL, $this->_url . "?" . $parameters);
            } else {
                curl_setopt($ch, CURLOPT_URL, $this->_url);
            }
            break;
        case "POST":
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_URL, $this->_url);
            if ($parameters) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
            }
            break;
        default:
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->_method);
            curl_setopt($ch, CURLOPT_URL, $this->_url);
            if ($parameters) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
            }
            break;
        } 


        // get response
        $response = curl_exec($ch);

        // get curl error code
        $this->_errorCode = curl_errno($ch);

        // close curl
        curl_close($ch);

        // check curl error code
        if (CURLE_OK != $this->_errorCode) {
            return false;
        }

        $ret = simplexml_load_string($response);
        return $ret;
    }

    /**
     * private _makeParameter 
     * @return parameter
     */
    private function _makeParameter()
    {
        $parameters = null;
        foreach ($this->_queryArray as $key => $query) {
            if (is_null($parameters)) {
                $parameters = $key . "=" . $query;
            } else {
                $parameters .= "&" . $key . "=" . $query;
            }
        }
        return $parameters;
    }

}

?>
