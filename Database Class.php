<?php 
/**************************************************************************************
 @ Module Name 	PHP Database Class 
 @ Category 	Database Access
 @ Author 		Abdallah BeraiDEV || Abdallah Beraidq <a.butenka@gmail.com>
 @ Copyright 	Copyright (c) 2017-2018
 @ License   	GNU Public License <http://opensource.org/licenses/gpl-3.0.html>
 @ Link 		.
 @ Version 		1.0.0-master
 ***************************************************************************************
 @ Methodes :
	- getSettings() 		: Login information for database.
	- connect() 			: Connect To The DataBase.
	- query($query)			: Executes a database query.
	- escapeString($query) 	: Escape strings for a database query.
	- numRows($result)		: Get number of rows in database as return.
	- lastInsertedID($conn) : Get last Inserted ID in the database.
	- fetchArray($result, $resultType) : Gets array of query results.
	- fetchAll($result, $resultType)   : Fetches all result rows as array.
	- fetchAssoc($result) 	: Get query using assoc method.
	- fetchRow($result)		: Get a result row as an enumerated array.
	- freeResult($result)	: Free all MySQLi result memory.
	- close()				: Closes the database connection.
	- sql_error() 			: Repporting errors in the database
 @ Attributes : 
 	- $conn 	  = The result of connection with database.
 	- $resultType = "MYSQLI_ASSOC" is default value, you can change it.
 	- $query 	  = SQLi query to search on the database.
 	- $result 	  = The result of seaching on the database.
 *****************************************************************************************/
 	
class DatabaseSettings {
	// Proprieties :
	public $settings;

	// Methodes :
	public function getSettings(){
		// Database variables
		$settings['dbhost'] 	= 'localhost'; 	# Host name
		$settings['dbusername'] = 'root'; 	 	# Username
		$settings['dbpassword'] = ''; 			# Password
		$settings['dbname'] 	= 'test'; 	  	# Database name
		return $settings;
	}

}

class Database extends DatabaseSettings
{
	// Proprieties :
	public $classQuery;
	public $link;
	public $errno = '';
	public $error = '';

	// Methodes :
	#= A #= Connect To The DataBase : 
	public function connect(){
		// Load settings from parent class
		$settings = DatabaseSettings::getSettings();
		
		// Get the main settings from the array we just loaded
		$host = $settings['dbhost'];
		$user = $settings['dbusername'];
		$pass = $settings['dbpassword'];
		$name = $settings['dbname'];
		
		// Connect to the database
		$this->link = new mysqli( $host , $user , $pass , $name );

		if ($this->link) {
			echo "success";
		}
	}
	#= B1 #= Executes a database query
	public function query( $query){
		$this->classQuery = $query;
		return $this->link->query($query);
	}
	#= B2 #= Executes a database query : escape strings
	public function escapeString( $query ){
		return $this->link->escape_string( $query );
	}
	#= C1 #= Get the data return 
	public function numRows( $result ) {
	    if (is_object($result)) {
	        $RowCount = $result->num_rows;
	    }
	    else{ 
	    	$RowCount = 0;
	    }
		return $RowCount;
	}
	#= C2 #= Get last Inserted ID
	public function lastInsertedID($conn){

		$this->link = $conn;
		printf ("New Record has id %d.\n", @mysqli_insert_id($conn)+1);
	}
	#= D1 #= Gets array of query results
	public function fetchArray( $result , $resultType = MYSQLI_ASSOC ){
		echo'<pre>';
		print_r($result->fetch_array($resultType));
		echo'</pre>';
	}
	#= E1 #= Fetches all result rows as an associative array, a numeric array, or both
	public function fetchAll( $result , $resultType = MYSQLI_ASSOC ){
		echo'<pre>';
		print_r($result->fetch_all( $resultType )) ;
		echo'</pre>';
	}
	#= F #= Get query using assoc method
	public function fetchAssoc( $result ){
		echo'<pre>';
		print_r($result->fetch_assoc()) ;
		echo'</pre>';
	}
	#= G #= Get a result row as an enumerated array
	public function fetchRow( $result ){
		echo'<pre>';
		print_r($result->fetch_row()) ;
		echo'</pre>';
	}
	#= H #= Free all MySQLi result memory
	public function freeResult( $result ){
		$this->link->free_result( $result );
	}
	#= I #= Closes the database connection
	public function close(){
		$this->link->close();
	}
	#= J #= Repporting errors in the database
	public function sql_error(){
		if( empty( $error ) ){
			$errno = $this->link->errno;
			$error = $this->link->error;
		}
		return $errno .' : ' .$error;
	}
}

