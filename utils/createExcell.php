<?php

class CreateExcell {

	public static function create($sql, $nombre)
	{
		/*******EDIT LINES 3-8*******/
		$DB_Server = _DB_HOST_; //MySQL Server 
		$DB_Username = _DB_USER_; //MySQL Username 
		$DB_Password = _DB_PASS_;             //MySQL Password 
		$DB_DBName = _DB_TABLE_;         //MySQL Database Name 
		//$DB_TBLName = "usuario"; //MySQL Table Name
		$filename = $nombre;         //File Name
		/*******YOU DO NOT NEED TO EDIT ANYTHING BELOW THIS LINE*******/
		//create MySQL connection
		//$sql = "Select * from $DB_TBLName";
		$Connect = @mysql_connect($DB_Server, $DB_Username, $DB_Password)
		    or die("Couldn't connect to MySQL:<br>" . mysql_error() . "<br>" . mysql_errno());
		//select database
		$Db = @mysql_select_db($DB_DBName, $Connect)
		    or die("Couldn't select database:<br>" . mysql_error(). "<br>" . mysql_errno());
		//execute query

		$result = @mysql_query($sql,$Connect)
		    or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
		$file_ending = "xls";
		 
		//header info for browser
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=$filename.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		 
		/*******Start of Formatting for Excel*******/
		//define separator (defines columns in excel & tabs in word)
		$sep = "\t"; //tabbed character
		 
		//start of printing column names as names of MySQL fields
		/*
		for ($i = 0; $i < mysql_num_fields($result); $i++) {
		echo mysql_field_name($result,$i) . "\t";
		}
		print("\n");
		*/
		//end of printing column names
		 
		//start while loop to get data
		print "<table border=1>";
	    while($row = mysql_fetch_row($result))
	    {
	        print "<tr>";
	        $schema_insert = "";
	        for($j=0; $j<mysql_num_fields($result);$j++)
	        {
	            print "<td>";
	            if(!isset($row[$j]))
	                //$schema_insert .= "NULL".$sep;
	                print "NULL";
	            elseif ($row[$j] != "")
	                //$schema_insert .= "$row[$j]".$sep;
	                print $row[$j];
	            else
	                //$schema_insert .= "".$sep;
	                print "";
	            print "</td>";
	        }
	        print "</tr>";
	        /*
	        $schema_insert = str_replace($sep."$", "", $schema_insert);
			$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
	        $schema_insert .= "\t";
	        print(trim($schema_insert));
	        print "\n";
	        */
	    }
	    print "</table>";
	}
	
}
?>