<?php

namespace Orm;


class Orm
{
	private static $connexion = NULL;

	public static function init($host, $db, $user, $password)
	{
		try {
			self::$connexion = new \PDO('mysql:host=' . $host . ';dbname=' . $db . ';charset=UTF8', $user, $password);
			self::$connexion->query("SET NAMES utf8;");
		} catch (\Exception $e) {
			echo 'Erreur(s) lors de la connexion a la BDD : ', $e->getMessage(), "\n";
		}

	}

	public static function getConnexion()
	{
		return self::$connexion;
	}

	public function registerLog($res, $query, $req)
	{
		$errorLog = __DIR__ . '/../Log/error.log';
		$accessLog = __DIR__ . '/../Log/access.log';

		$separator = "-------------------------------------------------------------------------------\n";
		$date = date("D M j G:i:s")." : ";

		if(!$res) {
			$errorMsg = $req->errorInfo();
			$data = $separator.$date.$errorMsg[2]."\n";
			file_put_contents($errorLog, $data, FILE_APPEND);
		} else {
			$queryMsg = $query;
			$data = $separator.$date.$queryMsg."\n";
			file_put_contents($accessLog, $data, FILE_APPEND);
		}
	}

	public function persist($object)
	{
		$tableName = $object->getTableNameBdd();
		$props = $object->getProperties();

		if($this->exist($object, 'id', $object->getId()) === false) {

			$tabFields = "INSERT INTO `" . $tableName . "` (";
			$tabFields2 = "";
			$i = 0;
			$count = count($props);

			foreach ($props as $key => $value) {
				$tabFields .= "`" . $key . "`";
				$i++;
				if ($i != $count) {
					$tabFields .= ",";
				}
			}

			$i = 0;
			foreach ($props as $key => $value) {
				$i++;
				if ($key != 'id') {
					$tabFields2 .= "'" . $value . "'";
					if ($i != $count) {
						$tabFields2 .= ", ";
					}
				}
			}

			$finalRequest = $tabFields . ") VALUES (NULL," . $tabFields2 . ")";

			$query = $finalRequest;
			$req = self::$connexion->prepare($query);
			$res = $req->execute();

			$this->registerLog($res, $query, $req);
		} else {

			$tabFields = "UPDATE `" . $tableName . "` SET ";

			$i = 0;
			$count = count($props);

			foreach ($props as $key => $value) {
				$i++;
				if ($key != 'id') {
					$tabFields .= "`" . $key . "`='".$value."'";
					if ($i != $count) {
						$tabFields .= ",";
					}
				}
			}

			$tabFields2 = " WHERE `id`=";

			foreach ($props as $key => $value) {
				if ($key === 'id') {
					$tabFields2 .= "'" . $value . "'";
				}
			}

			$finalRequest = $tabFields.$tabFields2;

			$query = $finalRequest;
			$req = self::$connexion->prepare($query);
			$res = $req->execute();

			$this->registerLog($res, $query, $req);
		}
	}

	public function getAll($object)
	{
		$tableName = $object->getTableNameBdd();

		$query = "SELECT * FROM `" . $tableName . "`";
		$req = self::$connexion->prepare($query);
		$req->execute();
		$res = $req->fetchAll();

		$this->registerLog($res, $query, $req);

		return $res;
	}

	public function deleteById($object)
	{
		$tableName = $object->getTableNameBdd();

		$query = "DELETE FROM `" . $tableName . "` WHERE id = " . $object->getId();
		$req = self::$connexion->prepare($query);
		$res = $req->execute();

		$this->registerLog($res, $query, $req);
	}

	public function delete($object, $rowname, $value)
	{
		$tableName = $object->getTableNameBdd();

		$query = "DELETE FROM `" . $tableName . "` WHERE `" . "$rowname" . "` = " . "'" . $value . "'";
		$req = self::$connexion->prepare($query);
		$res = $req->execute();

		$this->registerLog($res, $query, $req);
	}

	public function count($object)
	{
		$tableName = $object->getTableNameBdd();

		$query = "SELECT COUNT(*) FROM " . $tableName;
		$req = self::$connexion->prepare($query);
		$req->execute();
		$res = $req->fetch();

		$this->registerLog($res, $query, $req);
		return $res[0];
	}

	public function exist($object, $rowname, $value)
	{
		$tableName = $object->getTableNameBdd();

		$query = "SELECT * FROM `" . $tableName . "` WHERE `" . "$rowname" . "` = " . "'" . $value . "'";
		$req = self::$connexion->prepare($query);
		$req->execute();
		$res = $req->fetchAll();

		$this->registerLog($res, $query, $req);

		if(!$res){
			return false;
		} else {
			return true;
		}
	}
}