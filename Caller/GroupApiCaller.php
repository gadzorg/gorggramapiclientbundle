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

class GroupApiCaller extends AbstractCaller
{
    public function getUserGroup($username)
    {
        $content = $this->call("GET", '/accounts/' . $username . '/groups.json');

        $this->logger->info(sprintf("Get Groups on Gram, response : %s", $content));

        return json_decode($content);
    }

    public function getGroup($group)
    {  
        $content = $this->call("GET", '/groups/' . $group .'/groups.json');

        $this->logger->info(sprintf("Get %s group on Gram, response : %s", $group, $content));

        return json_decode($content);
    }
}
