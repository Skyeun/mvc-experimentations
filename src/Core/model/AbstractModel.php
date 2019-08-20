<?php


namespace Core\model;


class AbstractModel
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