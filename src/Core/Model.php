<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 14/12/18
 * Time: 21:28
 */

namespace Core;


/**
 * Class Model
 * @package Core
 */
class Model
{
    /**
     * Populate object with provided data
     *
     * @param array $data
     */
    protected function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method))
                $this->$method($value);
        }
    }
}