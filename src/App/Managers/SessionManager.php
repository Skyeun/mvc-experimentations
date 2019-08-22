<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 29/01/19
 * Time: 13:56
 */

namespace App\Managers;

use App\Models\Session;
use Core\Manager\Manager;

class SessionManager extends Manager
{
    public function __construct()
    {
    	parent::__construct(Session::class);
    }
}