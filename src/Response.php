<?php namespace CoryKeane\Slack;

use Psr\Http\Message\ResponseInterface as GuzzleResponse;

class Response
{
    /**
     * @var GuzzleResponse
     */
    protected $rawResponse;
    protected $response;
    protected $errorTypes = array(
        'invalid_auth' => 'Invalid authentication token',
        'account_inactive' => 'Authentication token is for a deleted user or team',
        'channel_not_found' => 'Value passed for channel was invalid',
        'is_archived' => 'Channel has been archived'
    );
    protected $error = null;

    public function __construct(GuzzleResponse $response)
    {
        $this->rawResponse = $response;
        $this->response = json_decode($response->getBody(), false);
    }

    public function statusCode()
    {
        return $this->rawResponse->getStatusCode();
    }

    public function isOkay()
    {
        $isOkay = $this->response->ok;
        if (!$isOkay) $this->error = $this->errorTypes[$this->response->error];
        return $isOkay;
    }

    public function getError()
    {
        return $this->error;
    }
}
