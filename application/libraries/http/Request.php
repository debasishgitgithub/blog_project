<?php

// namespace http;

/**
 * Request Handler
 * 
 * @author  Monirul Middya <monirulmiddya3@gmail.com>
 * @since 1.0.0
 * 
 */


class Request
{

    /**
     * @var string
     */
    private $_field_val = "";

    /**
     * @var array
     */
    private $_bodyParams;

    /**
     * @var string
     */
    private $_rawBody;

    /**
     * @var object CI_Controller
     */
    public $ci;

    function __construct()
    {
        // CI_Controller initialization
        $this->ci = &get_instance();
    }

    /**
     * Retrieves the HTTP method of the request.
     *
     * @return string
     */
    public function getMethod()
    {
        if (isset($_SERVER['HTTP_X-Http-Method-Override'])) {
            return strtoupper($_SERVER['HTTP_X-Http-Method-Override']);
        }
        if (isset($_SERVER['REQUEST_METHOD'])) {
            return strtoupper($_SERVER['REQUEST_METHOD']);
        }
        return 'GET';
    }

    /**
     * Retrieves the xmlhttprequest request check.
     *
     * @return bool
     */

    public function is_ajax()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    /**
     * Retrieves the content type check.
     *
     * @return bool
     */

    public function is_json()
    {
        return (!empty($this->getContentType()) && strtolower($this->getContentType()) == 'application/json');
    }

    /**
     * Retrieves the url segment match.
     *
     * @return bool
     */

    public function url_segment($segname, $pos = 1)
    {
        return ($this->ci->uri->segment($pos) == $segname);
    }

    /**
     * Return request content-type
     * 
     * @return string request content-type. - Null return if not available content-type.
     * @link https://tools.ietf.org/html/rfc2616#section-14.17
     * HTTP 1.1 header field definitions
     */
    public function getContentType()
    {
        return isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : null;
    }

    /**
     * Returns the raw HTTP request body.
     * @return string the request body
     */
    public function getRawBody()
    {
        if ($this->_rawBody === null) {
            $this->_rawBody = file_get_contents('php://input');
        }
        return $this->_rawBody;
    }

    /**
     * Returns the request parameters given in the request body.
     *
     * Request parameters are determined using the parsers depended on 'contentType'.
     * If no parsers are configured for the current [[contentType]] it uses the PHP function `mb_parse_str()`
     * to parse the [[rawBody|request body]].
     * 
     * @todo   Cache
     * @return array the request parameters given in the request body.
     */
    public function getBodyParams()
    {
        if ($this->_bodyParams === null) {

            $contType = $this->getContentType();

            if (strcasecmp($contType, 'application/json') == 0) {
                // for json content type
                $this->_bodyParams = json_decode($this->getRawBody(), true);
                $_POST = $this->_bodyParams;
            } elseif ($this->getMethod() === 'POST') {
                // form params in $_POST
                $this->_bodyParams = $_POST;
            } else {
                $this->_bodyParams = [];
                mb_parse_str($this->getRawBody(), $this->_bodyParams);
            }
        }

        return $this->_bodyParams;
    }

    /**
     * getBodyParams shortcut - alias
     * @return string the request body
     */

    public function all()
    {
        return $this->getBodyParams();
    }

    /**
     * get bodyPram value 
     * @param string $field - field name
     * @return string
     */

    public function get($field)
    {
        $_params = $this->getBodyParams();

        if (isset($_params[$field])) {
            $this->_field_val = $_params[$field];
        }

        return $this->_field_val;
    }

    /**
     * get header value 
     * @param string $field - field name
     * @return string
     */

    public function getHeader($key)
    {
        return isset(getallheaders()[$key]) ? getallheaders()[$key] : false;
    }
}

/* End of file Request.php */
/* Location: ./application/libraries/http/Request.php */