<?PHP

namespace Edu\Cnm\SproutSwap\DataDesign\Test;

abstract class DataDesignTest extends \PHPUnit_Extensions_Database_TestCase{
	/**
	 * invalid id to use for an INT UNSIGNED field (maximum allowed INT UNSIGNED in mySQL) + 1
	 * @see https://dev.mysql.com/doc/refman/5.6/en/integer-types.html mySQL Integer Types
	 * @var int INVALID_KEY
	 **/
	const INVALID_KEY = 4294967296;

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


}