<?php
	/* Functions:
	 * getRow($table, $cols, $vals) - Get the first row in '$table' where each column '$cols' matches the corresponding value in '$vals'
	 * getRows($table, $cols, $vals) - Get all rows in '$table' where each column '$cols' matches '$vals'
	 * addRow($table, $cols, $vals) - Add a row to '$table' where each column in '$cols' is set to the corresponding value in '$vals'
	 * getRowsByRange($table, $cols, $vals, $ranges) - Returns all rows in '$table' where each column in '$cols' is within '$vals' +/- '$ranges'
	 */

	 define("SERVERNAME", "mysql.connorwhite.org");
	 define("USERNAME", "ee461l_team");
	 define("PASSWORD", "c8XCrjcnss9E6fBX");
	 define("DATABASE", "pickupgame_db");

	//Returns the first row in '$table' where each column '$cols' matches the corresponding value in '$vals'
	function getRow($table, $cols, $vals){
		$result = getResult($table, $cols, $vals);
		$row = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $row;
	}

	//Return all rows in '$table' where each column '$col' matches '$vals'
	function getRows($table, $cols, $vals){
		$result = getResult($table, $cols, $vals);
		$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
		mysqli_free_result($result);
		return $rows;
	}

	//Returns all rows in '$table' where each column in '$cols' is within '$vals' +/- '$ranges'
	function getRowsByRange($table, $cols, $vals, $ranges){
		$result = getResultByRange($table, $cols, $vals, $ranges);
		$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
		mysqli_free_result($result);
		return $rows;
	}

	//Add a row to '$table' where each column in '$cols' is set to the corresponding value in '$vals'
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
		$pid = mysqli_insert_id($conn);
		mysqli_close($conn);
		return $pid;
	}

	//Returns a result from '$table' where the value in each column in '$col' matches the corresponding value in '$vals'
	function getResult($table, $cols, $vals){
		$conn = getConnection();

		$sql = "SELECT * FROM " . $table . " WHERE ";
		if(is_array($cols) && is_array($vals)){//if cols and vals are arrays
			for($c = 0; $c<count($cols) && $c<count($vals); $c++){//for each column
				$sql = $sql . "`" . $cols[$c] . "` = '" . $vals[$c] . "'";
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

	function getResultByRange($table, $cols, $vals, $ranges){
		$conn = getConnection();

		$sql = "SELECT * FROM " . $table . " WHERE ";
		if(is_array($cols) && is_array($vals) && is_array($ranges)){//if cols and vals are arrays
			for($c = 0; $c<count($cols) && $c<count($vals); $c++){//for each column
				$sql = $sql . "`" . $cols[$c]. "` <= '" . ($vals[$c]+$ranges[$c]) . "' AND `" . $cols[$c]. "` >= '" . ($vals[$c]-$ranges[$c]) . "'";
				if(($c + 1) < count($cols)){
					$sql = $sql . " AND ";
				}
			}
		} else {//If cols and vals are variables
			$cols = arrayToVar($cols);
			$vals = arrayToVar($vals);
			$sql = $sql . "`" . $cols . "` <= '" . ($vals+$ranges) . "' AND `" . $cols . "` >= '" . ($vals-$ranges) . "'";
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
		$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
		if($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		return $conn;
	}
