<?php

/**
 * @author Pramod Kumar Raghav
 *
 */

 class jwtAuthenticateMiddleware
 {
	/**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
		$item = new stdClass();
		$item->_id = $request->getHeaderLine('User-id');

        var_dump($this->jwt);

        if($item->_id == $this->jwt->data->_id){
            $response = $next($request, $response);
        }else{
            $response->withStatus(401); // Unauthorized
        }
		return $response;
    }	
 }