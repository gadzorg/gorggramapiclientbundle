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

namespace Gorg\Bundle\GramApiClientBundle\Entity;

class StdApiEntity
{
    /**
     * @var $attributes
     */
    private $attributes;

    /**
     * Build a StdApiEntity object
     * 
     * @param Array  $attributes        the array of attribute of user
     */
    public function __construct($attributes)
    {  
        $this->attributes        = $attributes;
    }

    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Call non existant method
     */
    public function __call($name, $arguments)
    {  
        if(preg_match('/^get/', $name))
        {
            if(count($arguments) > 0)
            {
                throw new \BadMethodCallException();
            }
            $varNameWithUpperLetter =  preg_replace('/^get/','', $name);
            $varName = lcfirst($varNameWithUpperLetter); 
            if(!isset($this->attributes[$varName]))
            {
                return null;
            }
            return $this->attributes[$varName];
        } elseif(preg_match('/^set/', $name)) {  
            if(count($arguments) > 1)
            {  
                throw new \BadMethodCallException();
            }
            $varNameWithUpperLetter =  preg_replace('/^get/','', $name);
            $varName = lcfirst($varNameWithUpperLetter);
            $this->attributes[$varName] = $arguments[0];
            return true;
       }
    }

    public function __get($property)
    {
        if (isset($this->attributes[$property])) {
            return $this->attributes[$property];
        } else {
            return false;
        }
    }

    public function __set($property, $value)
    {
        return $this->attributes[$property] = $value;
    }

    public static function buildFromStdClass(\stdClass $baseEntityInstance)
    {
        $vars = get_object_vars($baseEntityInstance);
        return new StdApiEntity($vars);
    }
}
