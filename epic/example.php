profileName VARCHAR (30),

CREATE TABLE mode (
modeId INT UNSIGNED AUTO_INCREMENT NOT NULL,
modeName VARCHAR (20),

PRIMARY KEY (modeId)

public static function getProfileByProfileActivation(\PDO $pdo, string $profileActivation){
$profileActivation = trim($profileActivation);
$profileActivation = filter_var($profileActivation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
if(empty($profileActivation) === true){
throw(new \PDOException("profile activation is invalid"));
}

$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile WHERE profileId = :profileId";
$statement = $pdo->prepare($query);

$parameters = ["profileActivation" => $profileActivation];
$statement->execute($parameters);

$profileActivation = new \SplFixedArray(($statement->rowCount()));
$statement->setFetchMode(\PDO::FETCH_ASSOC);
while(($row = $statement->fetch() !== false));
try {
$profileActivation = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], $row["profileTimestamp"], $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
$profileActivation[$profileActivation->key()] = $profileActivation;
$profileActivation->next();
}catch(\Exception $exception){
throw(new \PDOException($exception->getMessage(), 0, $exception));
}
return($profileActivation);

/**
* get the profile activation by profile
*
* @param \PDO $pdo PDO conncetion object
* @param int $profileActivation profile activation to search for
* @return Profile|null profile activation or null if not found
* @throws \PDOException when mySQL related errors occur
* @throws \TypeError when variables are not the correct data type
**/