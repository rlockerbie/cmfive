<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class AcceptanceHelper extends \Codeception\Module
{
  /**
     * Run all sql files in a given directory
     */
    public function runSQLQueries($dir = null)
    {
		if(!is_null($dir)){
             // parse parameters to extract path (not symlinked source path)
			 $env='';
			 $basePath='';
			 for($i=0; $i< count($GLOBALS['argv']); $i++) {
				 if (strpos(' '.$GLOBALS['argv'][$i],'--config=')>0) {
					$pathParts=explode('config=',$GLOBALS['argv'][$i]);
					$basePath=$pathParts[1].DS;
				 } else if (strpos(' '.$GLOBALS['argv'][$i],'--env')>0) {
					 $env=trim($GLOBALS['argv'][$i+1]);
				 }
			 }
			 /**
             * We need the Db module to run the queries
             */
            $dbh = $this->getModule('Db');
            
            /**
             * The Db driver load function requires an array
             */
            $queries = array();

            /**
             * Get all the queries in the directory
             */
            foreach(glob($basePath.'tests'.DS.'_data'.DS. $dir.DS.'*.sql') as $sqlFile){
              
                //echo "\n".'Import SQL from test :'.$sqlFile."\n";
                $query = file_get_contents($sqlFile);
                //echo $query;
                array_push($queries, $query);
            }
            
            /**
             * If there are queries load them
             */
            if(count($queries) > 0){
                $dbh->driver->load($queries);
            }
            
			ob_flush();
            
        }
    }
}