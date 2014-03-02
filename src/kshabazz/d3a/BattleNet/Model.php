<?php namespace kshabazz\d3a;
/**
 * Get the users item from Battle.Net and present it to the user; store it locally in a database behind the scenes.
 * The item will only be updated after a few ours of retrieving it.
 */

/**
 * Class BattleNet_Model
 *
 * @package kshabazz\d3a
 */
abstract class BattleNet_Model
{
	protected
		$dqi,
		$json,
		$key,
		$loadFromDb,
		$requestSuccessful,
		$sql;

    /**
     * Constructor
     * @param                     $pKey
     * @param BattleNet_Requestor $pDqi
     * @param Sql                 $pSql
     * @param bool                $pLoadFromCache
     */
    public function __construct( $pKey, BattleNet_Requestor $pDqi, Sql $pSql, $pLoadFromCache = TRUE )
	{
		$this->dqi = $pDqi;
		$this->json = NULL;
		$this->key = $pKey;
        $this->loadFromDb = $pLoadFromCache;
		$this->requestSuccessful = FALSE;
		$this->sql = $pSql;

        $this->pullJson()
             ->save();
	}

    /**
     * Get raw JSON data returned from Battle.net.
     * @return null
     */
    public function json()
	{
		return $this->json;
	}

    /**
     * Get the JSON from the DB if $loadFromDb is true, or pull from Battle.net.
     * @return $this
     */
    protected function pullJson()
    {
        if ( $this->loadFromDb )
        {
            $this->pullJsonFromDb();
        }
        else
        {
            $this->requestJsonFromApi();
        }
        return $this;
    }

	/**
	 * Get the JSON from Battle.Net.
	 * @return $this
	 */
	abstract protected function requestJsonFromApi();

	/**
	 * Get JSON data from a database.
	 * @return $this
	 */
	abstract protected function pullJsonFromDb();

	/**
	 * Save data (usually JSON pulled from the API) to a local database.
	 * @return bool Indicates TRUE on success or FALSE when skipped or a failure occurs.
	 */
	abstract protected function save();
}
?>