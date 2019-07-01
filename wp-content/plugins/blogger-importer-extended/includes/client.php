<?php if (!defined('ABSPATH')) die;

require 'settings.php';

class BIEClient
{
    const TOKEN = 'bie_token';

    private $token;

    public function __construct()
    {
        $this->blog = BIECore::blog();
        $this->token = get_option(self::TOKEN);
    }

    public function ready()
    {
        return (bool)$this->token;
    }

    public function call($operation, $params = array())
    {
        $url = BIESettings::API_URL . '/' . $operation . '.php';

        $params['blog'] = $this->blog;

        if ($this->ready()) {
            $params['token'] = $this->token;
        }

        $response = wp_remote_post($url, array(
            'body' => $params,
            'timeout' => 15,
        ));

        if (is_wp_error($response)) {
            die($response->get_error_message());
        }

        $response = json_decode($response['body']);

        // Handle errors
        if (property_exists($response, 'error')) {
            if (is_object($response->error)) {
                // TODO: Get the API to return an 'invalid-session' response code
                // instead of filtering the message. 
                if (strpos($response->error->message, 'Invalid Credentials') !== false) {
                    throw new ClientInvalidSession();
                }

                throw new ClientErrorException($response->error->message);
            }

            if ($response->code == 'invalid-session') {
                throw new ClientInvalidSession();
            }

            throw new ClientErrorException($response->error);
        }

        if (property_exists($response, 'token')) {
            update_option(self::TOKEN, $response->token);
        }

        return $response;
    }

    public function reset()
    {
        $this->token = null;
        delete_option(self::TOKEN);
    }
}

class ClientInvalidSession extends Exception {}
class ClientErrorException extends Exception {}