<?php namespace kshabazz\d3a;
/**
* Request a hero from BattleNet.
*/
class BattleNet_Hero extends BattleNet_Model
{
	protected
		$characterClass,
		$items,
		$key,
		$stats;

	/**
	* Constructor
	*/
	public function __construct( $pKey, BattleNet_Requestor $pDqi, BattleNet_Sql $pSql, $pForceLoadFromBattleNet )
	{
		$this->characterClass = NULL;
		$this->items = NULL;
		$this->stats = NULL;
		parent::__construct( $pKey, $pDqi, $pSql, $pForceLoadFromBattleNet );
	}

	/**
	* Destructor
	*/
	public function __destruct()
	{
		unset(
			$this->characterClass,
			$this->dqi,
			$this->forceLoadFromBattleNet,
			$this->key,
			$this->info,
			$this->items,
			$this->json,
			$this->loadedFromBattleNet,
			$this->sql,
			$this->stats
		);
	}

	/**
	* Character class
	*
	* @return string
	*/
	public function characterClass()
	{
		return $this->characterClass;
	}

	/**
	* Get the item, first check the local DB, otherwise pull from Battle.net.
	*
	* @return array
	*/
	public function items()
	{
		return $this->items;
	}

	/**
	* Get raw JSON data returned from Battle.net.
	*/
	public function json()
	{
		return $this->json;
	}

	/**
	* Get character stats.
	*
	* @return array
	*/
	public function stats()
	{
		return $this->stats;
	}

	/**
	* Get the item, first check the local DB, otherwise pull from Battle.net.
	*
	* @return string JSON item data.
	*/
	protected function pullJson()
	{
		if ( !$this->forceLoadFromBattleNet ) // From DB
		{
			$this->pullJsonFromDb();
		}

		if ( $this->json === null ) // From Battle.Net
		{
			$this->pullJsonFromBattleNet();
		}
		return $this;
	}

	/**
	* Get the JSON from Battle.Net.
	* @return Hero
	*/
	protected function pullJsonFromBattleNet()
	{
		// Request the hero from BattleNet.
		$responseText = $this->dqi->getHero( $this->key );
		$responseCode = $this->dqi->responseCode();
		$this->url = $this->dqi->getUrl();
		// Log the request.
		$this->sql->addRequest( $this->dqi->battleNetId(), $this->url );
		if ( $responseCode === 200 )
		{
			$this->json = $responseText;
			$this->loadedFromBattleNet = TRUE;
		}
		return $this;
	}

	/**
	* Get hero data from local database.
	* @return Hero
	*/
	protected function pullJsonFromDb()
	{
		$result = $this->sql->getHero( $this->key );
		if ( isArray($result) )
		{
			$this->json = $result[ 0 ][ 'json' ];
		}
		return $this;
	}

	/**
	* Load the users hero into this class
	*/
	protected function processJson()
	{
		// Convert the JSON to an associative array.
		if ( isString($this->json) )
		{
			$hero = parseJson( $this->json );
			if ( isArray($hero) )
			{
				$this->items = $hero[ 'items' ];
				$this->characterClass = $hero[ 'class' ];
				if ( $this->loadedFromBattleNet )
				{
					$this->save();
				}
			}
		}
		return $this;
	}

	/**
	* Save the users hero in a local database.
	* @return bool Indicates success (TRUE) or failure (FALSE).
	*/
	protected function save()
	{
		$utcTime = gmdate( "Y-m-d H:i:s" );
		return $this->sql->save( BattleNet_Sql::INSERT_HERO, [
			"heroId" => [ $this->key, \PDO::PARAM_STR ],
			"battleNetId" => [ $this->dqi->battleNetId(), \PDO::PARAM_STR ],
			"json" => [ $this->json, \PDO::PARAM_STR ],
			"ipAddress" => [ $this->sql->ipAddress(), \PDO::PARAM_STR ],
			"lastUpdated" => [ $utcTime, \PDO::PARAM_STR ],
			"dateAdded" => [ $utcTime, \PDO::PARAM_STR ]
		]);
	}
}
?>
