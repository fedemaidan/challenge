<?php
/**
 * This singleton has the responsability to manage data
 *
 */

namespace Services;


class MongoManager
{
    private $db = "test";


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
		$result = $manager->executeBulkWrite($this->db.'.'.$collecionsName, $bulk);
    }

    public function get($collecionsName, $filter = []) {
    	$manager = new \MongoDB\Driver\Manager( "mongodb://mongodb" ); 
    	$query = new \MongoDB\Driver\Query($filter, []);
		$documentsObj = $manager->executeQuery($this->db.'.'.$collecionsName, $query); 	
		$return = [];
		foreach ($documentsObj as $doc) {
			$return[] = $doc;
		}
		return $return;
    }

    public function update($collecionsName, $filter, $updates) {
        $manager = new \MongoDB\Driver\Manager( "mongodb://mongodb" ); 
        $bulk = new \MongoDB\Driver\BulkWrite();
        $bulk->update($filter, ['$set' => $updates], ['multi' => false, 'upsert' => false]);
        $result = $manager->executeBulkWrite($this->db.'.'.$collecionsName, $bulk);   
    }

    public function delete($collecionsName, $filter) {
        $manager = new \MongoDB\Driver\Manager( "mongodb://mongodb" ); 
        $bulk = new \MongoDB\Driver\BulkWrite();
        $bulk->delete($filter, ['limit' => 1]);
        $result = $manager->executeBulkWrite($this->db.'.'.$collecionsName, $bulk);   
        
    }

}