<?php
/***************************************************************************
 * Copyright (C) 1999-2012 Gadz.org                                        *
 * http://opensource.gadz.org/                                             *
 *                                                                         *
 * This program is free software; you can redistribute it and/or modify    *
 * it under the terms of the GNU General Public License as published by    *
 * the Free Software Foundation; either version 2 of the License, or       *
 * (at your option) any later version.                                     *
 *                                                                         *
 * This program is distributed in the hope that it will be useful,         *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of          *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the            *
 * GNU General Public License for more details.                            *
 *                                                                         *
 * You should have received a copy of the GNU General Public License       *
 * along with this program; if not, write to the Free Software             *
 * Foundation, Inc.,                                                       *
 * 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA                   *
 ***************************************************************************/

namespace Gorg\Bundle\GramApiClientBundle\Caller;

abstract class AbstractCaller
{
    protected $apiUser;
    protected $apiPassword;
    protected $apiPath;
    protected $apiServer;
    protected $logger;
    protected $buzz;

    public function __construct($logger, $buzz, $user, $password, $path, $server)
    {
        $this->buzz        = $buzz;
        $this->logger      = $logger;
        $this->apiUser     = $user;
        $this->apiPassword = $password;
        $this->apiPath     = $path;
        $this->apiServer   = $server;
    }

    protected function call($method, $url, $data = null)
    {
       if(!in_array($method, array("GET", "POST", "DELETE", "PUT"))) {
           throw new \BadMethodCallException();
       }
       $request = new \Buzz\Message\Request($method, $this->apiPath . $url, $this->apiServer);
       $response = new \Buzz\Message\Response();

       $request->addHeader('Authorization: Basic '.base64_encode($this->apiUser.':'.$this->apiPassword));
       $request->addHeader('Accept: application/json');
       $request->addHeader('Content-type: application/json');

       if(in_array($method, array("POST", "PUT"))) {
           $request->setContent(json_encode($data));
       }

       $this->logger->info(sprintf("Send %s request on gram : %s%s with data: %s",  $method, $this->apiServer, $this->apiPath . $url, json_encode($data)));
       $this->buzz->send($request, $response);

       return $response->getContent();
    }
}
