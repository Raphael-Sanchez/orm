<?php

require_once('autoloader.php');

use Orm\Orm;

//localhost testorm root root users users

$dbHost = $argv[1];
$dbName = $argv[2];
$dbUser = $argv[3];
$dbPass = $argv[4];
$tableName = $argv[5];
$className = ucfirst($argv[6]);

// Connexion à la BDD & requête afin de récuperer chaque nom de colonnes
Orm::init($dbHost, $dbName, $dbUser, $dbPass);
$req = Orm::getConnexion()->prepare('SHOW COLUMNS FROM '.$tableName);
$req->execute();
$fields = $req->fetchAll(PDO::FETCH_COLUMN, 0);

$space = 4;

function do_tabs($space)
{
    $ret = '';

    for ($i = 0; $i < $space; $i ++)
        $ret .= ' ';
    return $ret;
}

$code = "<?php\n\n";

$code .= "namespace Model;\n\n";

$code .= "class $className\n{\n";

foreach ($fields as $field)
{
    $code .= do_tabs($space) . 'protected $'.$field.";\n";
}

$code .= "\n";

$code .= do_tabs($space) . 'public function getProperties'.'()'."\n";
$code .= do_tabs($space) . "{\n";
$code .= do_tabs($space+2) . 'return get_object_vars($this);'."\n";
$code .= do_tabs($space) . "}\n";
$code .= "\n";

$code .= do_tabs($space) . 'public function getTableNameBdd'.'()'."\n";
$code .= do_tabs($space) . "{\n";
$code .= do_tabs($space+2) . 'return '."'".$tableName."'".";\n";
$code .= do_tabs($space) . "}\n";
$code .= "\n";

foreach ($fields as $field)
{
    $code .= do_tabs($space) . 'public function set'.ucfirst($field).'($' .$field.")\n";
    $code .= do_tabs($space) . "{\n";
    $code .= do_tabs($space+2) . 'return $this->'.$field.' = $'.$field.";\n";
    $code .= do_tabs($space) . "}\n";
    $code .= "\n";
    $code .= do_tabs($space) . 'public function get'.ucfirst($field).'()'."\n";
    $code .= do_tabs($space) . "{\n";
    $code .= do_tabs($space+2) . 'return $this->'.$field.";\n";
    $code .= do_tabs($space) . "}\n";
    $code .= "\n";
}

$code .= "}\n";

file_put_contents('Model/'.$className.".php", $code);