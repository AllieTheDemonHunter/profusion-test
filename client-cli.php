#!/usr/bin/php
<?php
/**
 * Profusion PHP CLI Test
 * @author Allie du Plooy
 * @copyright CC BY-SA, 2014
 */
if ($argc != 2 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
?>

This is a command line PHP script with one option.

  Usage:
  <?php echo $argv[0]; ?> <option>

  <option> can be one of the following: 
  
  -E Executes the data transfer from table source_cdr to destination_cdr.
  -f Fetches the rows from source_cdr.
  -g Gets the rows from destination_cdr.
  -T Empties destination_cdr.
  
  With the --help, -help, -h,
  or -? options, you can get this help.

<?php
} else {
	include_once 'database.php';
    switch ($argv[1]){
		case "-E":
			$go_look = $pdo_destination->prepare("
						SELECT `clid` 
						FROM `destination_cdr` 
						WHERE `clid` IS NOT NULL");
			$go_look->execute();
			$existing = $go_look->fetchAll();
			$comma = "";
			if(is_array($existing)){
				foreach ($existing as $row) {
					$sql_snip .= $comma.$row[0];
					$comma = ", ";
				}
			}
			if($sql_snip == "") {
				$sql_snip = "''";
			}
			$check_sql = "
				SELECT `callstart`, `src`, `dst`, `accountcode`, `ID`,`pin_code`, TIME_TO_SEC(TIMEDIFF(`callend`,`callstart`)), TIME_TO_SEC(TIMEDIFF(`callend`,`callanswer`)), `disposition`, `cdr_id`, `provider`
				FROM `source_cdr`
				WHERE `ID` IS NOT NULL
					AND `source_cdr`.`ID` NOT IN (".$sql_snip.")";
			$check_statement = $pdo_source->prepare($check_sql);
			$check_statement->execute();
			
			$count = $check_statement->rowCount();
			if($count > 0){
				$percentage_increments = (100/$count);
				print "
Sending rows
";
				for($t = 0; $t < $count; $t++){
					$result = $check_statement->fetch(PDO::FETCH_NUM);
					print " |".floor($t*$percentage_increments)."%";
					$copy_statement = $pdo_destination->prepare("
						INSERT INTO destination_cdr (
							`calldate`, 
							`source`, 
							`destination`, 
							`account_code`,
							`clid`, 
							`pincode`,
							`duration_call`,
							`duration_talk`,
							`disposition`,
							`cdr_id`,
							`provider`)
						VALUES (
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
						)
						");
					$start_time = time();
					sleep(1);
					$copy_statement->execute($result);
					$time_taken += (time() - $start_time);
				}
				print " |100% - Done in ".$time_taken." seconds

";
			} else {
				print "No suitable rows were found to copy (prevents duplication).
";				
			}
			break;
		case "-f":
			$check_statement = $pdo_source->prepare("SELECT * FROM source_cdr");
			$check_statement->execute();
			print_r($check_statement->fetchAll());
			break;
		case "-g":
			$check_statement = $pdo_destination->prepare("SELECT * FROM beta.destination_cdr");
			$check_statement->execute();
			print_r($check_statement->fetchAll());
			break;
		case "-T":
			$check_statement = $pdo_source->prepare("TRUNCATE beta.destination_cdr");
			$check_statement->execute();
?>
beta.destination_cdr was emptied.
<?php
			break;
	}
}
?>