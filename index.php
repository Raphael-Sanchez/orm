<?php

require_once('autoloader.php');

use Orm\Orm;
use Model\Users;

$initialisation = Orm::init('localhost', 'testorm', 'root', 'root');


$orm = new Orm();

// INSERT IN BDD
//$user = new Users();
//$user->setName('Raphael');
//$user->setMail('raphael.sanchez@supinternet.fr');
//$user->setPassword(sha1('qwerty123'));
//$orm->persist($user);
//<--------------------------------------    -------------------------------------->


// GET
//$orm = new Orm();
//$users = new Users();
//$tabUsers = $orm->getAll($users);
//var_dump($tabUsers);
//
//foreach($tabUsers as $user){
//    echo 'Nom : ' . $user['name'] . '<br>';
//    echo 'Email : ' . $user['mail'] . '<br>';
//    echo 'Password : ' . $user['password'] . '<br>';
//    echo '----<br>';
//}
//<--------------------------------------    -------------------------------------->


// DELETE BY ID
//$orm = new Orm();
//$users = new Users();
//$users->setId('40');
//$orm->deleteById($users);
//<--------------------------------------    -------------------------------------->


// DELETE (PARAMETERS $OBJECT, $ROWNAME AND $VALUE)
//$users = new Users();
//$orm->delete($users, 'name', 'pablo');
//<--------------------------------------    -------------------------------------->


//<--------------------------------------HELPERS-------------------------------------->
// COUNT
//$users = new Users();
//$count = $orm->count($users);
//var_dump($count);
//<--------------------------------------    -------------------------------------->


// EXIST (PARAMETERS $OBJECT, $ROWNAME AND $VALUE)
//$users = new Users();
//$res = $orm->exist($users, 'name', 'wjeihhfuewhu');
//var_dump($res);
//<--------------------------------------    -------------------------------------->

// SELECT
//$users = new Users();
//$orm->select();
