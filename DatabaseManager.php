<?php
	/* Functions:
	 * getRow($table, $cols, $ids) - Get the first row in '$table' where each column '$cols' matches the corresponding value in '$ids'
	 * getRows($table, $col, $id) - Get all rows in '$table' where each column '$col' matches '$id'
	 * addRow($table, $col, $id) - Add a row to '$table' where each column in '$cols' is set to the corresponding value in '$values'
	 */

	//Returns the first row in '$table' where each column '$cols' matches the corresponding value in '$ids'
	function getRow($table, $cols, $ids){
		$result = getResult($table, $cols, $ids);
		$row = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $row;
	}

	//Return all rows in '$table' where each column '$col' matches '$id'
	function getRows($table, $col, $id){
		$result = getResult($table, $col, $id);
		$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
		mysqli_free_result($result);
		return $rows;
	}

	//Add a row to '$table' where each column in '$cols' is set to the corresponding value in '$values'
	function addRow($table, $cols, $vals){
		$conn = getConnection();

		$sql = "INSERT INTO `" . $table . "` (";
		if(is_array($cols) && is_array($vals)){//if cols and vals are arrays
			for($c = 0; $c<count($cols) && $c<count($vals); $c++){//For each column in cols
				$sql = $sql . "`" . $cols[$c] . "`";
				if($c < count($cols)-1)//If not the last entry
					$sql = $sql . ", ";
			}

			$sql = $sql . ") VALUES (";
			for($c = 0; $c<count($cols) && $c<count($vals); $c++){//For each value in values
				$sql = $sql . "'" . $vals[$c] . "'";
				if($c < count($vals)-1)//If not the last entry
					$sql = $sql . ", ";
			}
			$sql = $sql . ")";
		} else {//cols and values are single values
			$cols = arrayToVar($cols);
			$vals = arrayToVar($vals);
			$sql = $sql . "`" . $cols . "`) VALUES ('" . $vals . "')";
		}
		echo($sql);

		mysqli_query($conn, $sql);
		mysqli_close($conn);
	}

	//Returns a result from '$table' where the value in each column in '$col' matches the corresponding value in '$vals'
	function getResult($table, $cols, $vals){
		$conn = getConnection();

		$sql = "SELECT * FROM " . $table . " WHERE ";
		if(is_array($cols) && is_array($vals)){//if cols and vals are arrays
			for($c = 0; $c<count($cols) && $c<count($vals); $c++){//for each column
				$sql = $sql . "`" . $cols[$c]. "` = '" . $vals[$c] . "'";
				if(($c + 1) < count($cols)){
					$sql = $sql . " AND ";
				}
			}
		} else {//If cols and vals are variables
			$cols = arrayToVar($cols);
			$vals = arrayToVar($vals);
			$sql = $sql . "`" . $cols . "` = '" . $vals . "'";
		}

		$result = mysqli_query($conn, $sql);
		mysqli_close($conn);

		return $result;
	}

	function arrayToVar($array){
		if(is_array($array))
			return $array[0];
		return $array;
	}

	//Returns a connection to the database
	function getConnection(){
		$servername = "mysql.connorwhite.org";
		$username = "ee461l_team";
		$password = "c8XCrjcnss9E6fBX";
		$database = "pickupgame_db";

		$conn = new mysqli($servername, $username, $password, $database);
		if($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		return $conn;
	}
