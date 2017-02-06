<?php
namespace Edu\Cnm\SproutSwap\SproutSwapTest;

// grab the encrypted properties file
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

abstract class SproutSwapTest extends \PHPUnit_Extensions_Database_TestCase{
	/**
	 * invalid id to use for an INT UNSIGNED field (maximum allowed INT UNSIGNED in mySQL) + 1
	 * @see https://dev.mysql.com/doc/refman/5.6/en/integer-types.html mySQL Integer Types
	 * @var int INVALID_KEY
	 **/
	const INVALID_KEY = 4294967296;
	/**
	 * PHP database connection interface
	 * @var null
	 */
	protected $connection = null;
	/**
	 * assembles table from our data set outline for PHPUnit
	 * @return \PHPUnit_Extensions_Database_DataSet_QueryDataSet
	 */
	public final function getDataSet(){
		$dataset = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
		//add all project table IN ORDER OF CREATION
		$dataset->addTable("image");
		$dataset->addTable("mode");
		$dataset->addTable("profile");
		$dataset->addTable("post");
		$dataset->addTable("postImage");
		$dataset->addTable("message");
		return($dataset);
	}
	/**
	 * @return \PHPUnit_Extensions_Database_Operation_Composite
	 */
	public final function getSetUpOperation(){
		return new \PHPUnit_Extensions_Database_Operation_Composite(array(\PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL(),
			\PHPUnit_Extensions_Database_Operation_Factory::INSERT()
		));
	}
	/**
	 * tear down method; expunges all test data
	 * @return mixed
	 */
	public final function getTearDownOperation(){
		return(\PHPUnit_extension_Database_operation_factory::DELETE_ALL());
	}
	/**
	 * sets up database connection for PHPUnit
	 * @return mixed
	 */
	public final function getConnection(){
		if($this->connection === null){
			$config = readConfig("/etc/apache2/capstone-mysql/sprout-swap.ini");
			$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/sprout-swap.ini");
			$this->connection = $this->createDefaultDBConnection($pdo, $config["database"]);
		}
		return($this->connection);
	}
	/**
	 * returns the PDO object for convenience
	 * @return mixed
	 */
	public final function getPDO(){
		return($this->getConnection()-$this->getConnection());
	}
}