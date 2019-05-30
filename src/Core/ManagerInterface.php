<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 29/01/19
 * Time: 13:57
 */

namespace Core;


/**
 * Interface ManagerInterface
 * @package Core
 */
interface ManagerInterface
{
    /**
     * @param integer $id
     * @return mixed
     */
    public function findById($id);

    /**
     * @param array $criteria
     * @param array $parameters
     * @return array
     */
    public function search($criteria, $parameters);

    /**
     * @param object $object
     * @return boolean
     */
    public function insert($object);

    /**
     * @param object $object
     * @return boolean
     */
    public function update($object);

    /**
     * @param object $object
     * @return boolean
     */
    public function delete($object);
}