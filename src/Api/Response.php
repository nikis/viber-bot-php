<?php

namespace Viber\Api;

use Viber\Http\HttpResponseInterface;
use Viber\Api\Exception\ApiException;

/**
 * Manage backend response, translate api error ot exception
 *
 * @author Novikov Bogdan <hcbogdan@gmail.com>
 */
class Response
{
    /**
     * Raw response data
     *
     * @var array
     */
    protected $data;

    /**
     * Create api response from http-response
     *
     * @param  HttpResponseInterface $response network response
     * @return \Viber\Api\Response
     * @throws \Viber\Api\Exception\ApiException
     */
    public static function create(HttpResponseInterface $response)
    {
        // - validate body
        $data = json_decode($response->getBody(), true);
        if (empty($data)) {
            throw new ApiException('Invalid response body');
        }
        // - validate internal data
        if (isset($data['status'])) {
            if ($data['status'] != 0) {
                throw new ApiException('Remote error: ' .
                    (isset($data['status_message']) ? $data['status_message'] : '-'),
                    $data['status']);
            }
            $item = new self();
            $item->data = $data;
            return $item;
        }
        throw new ApiException('Invalid response json');
    }

    /**
     * Get the value of Raw response data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
