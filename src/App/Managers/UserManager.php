<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 14/12/18
 * Time: 20:26
 */

namespace App\Managers;


use App\Models\User;
use Core\Manager\Manager;

class UserManager extends Manager
{
    public function __construct()
    {
        parent::__construct(User::class);
    }
}