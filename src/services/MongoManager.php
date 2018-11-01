<?php

/*
$bulk = new MongoDB\Driver\BulkWrite;

$document1 = ['title' => 'one'];
$document2 = ['_id' => 'custom ID', 'title' => 'two'];
$document3 = ['_id' => new MongoDB\BSON\ObjectId, 'title' => 'three'];

$_id1 = $bulk->insert($document1);
$_id2 = $bulk->insert($document2);
$_id3 = $bulk->insert($document3);

var_dump($_id1, $_id2, $_id3);

$manager = new MongoDB\Driver\Manager( "mongodb://mongodb" ); 
$result = $manager->executeBulkWrite('test.testeo', $bulk);

<?php

/**
 * This singleton has the responsability to manage data
 *
 */

namespace Services;


class MongoManager
{
    private $db;


    /**
     * Call this method to get singleton
     *
     * @return MongoManager
     */

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new MongoManager();
        }
        return $inst;
    }


    public function insert($collecionsName, $document) {
    	$bulk = new \MongoDB\Driver\BulkWrite;
		$bulk->insert($document);
		$manager = new \MongoDB\Driver\Manager( "mongodb://mongodb" ); 
		$result = $manager->executeBulkWrite('test.'.$collecionsName, $bulk);
    }

    public function get($collecionsName, $filter = []) {
    	$manager = new \MongoDB\Driver\Manager( "mongodb://mongodb" ); 
    	$query = new \MongoDB\Driver\Query($filter, []);
		$documentsObj = $manager->executeQuery('test.'.$collecionsName, $query); 	
		$return = [];
		foreach ($documentsObj as $doc) {
			$return[] = $doc;
		}
		return $return;
    }

}
/*
$manager = new MongoDB\Driver\Manager( "mongodb://mongodb" ); 

$filter = ['id' => 2];
$options = [
   'projection' => ['_id' => 0],
];
$query = new MongoDB\Driver\Query([], []);
$rows = $manager->executeQuery('test.testeo', $query); // $mongo contains the connection object to MongoDB
foreach($rows as $r){
   var_dump($r);
}


?>
*/