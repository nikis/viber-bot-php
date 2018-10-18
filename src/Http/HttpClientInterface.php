<?php
namespace Viber\Http;

/**
 * Base http interface for viber client
 *
 * @author nikis <nikigape@gmail.com>
 */
interface HttpClientInterface {
	
	public function request($method, $uri, array $data);
	
}

