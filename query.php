<html>

<head>

    <title>project query</title>
</head>

<body>
<a href="main.php"> Back to Main </a><br/>


    <h2>SELECTION</h2>

    <form method="GET" action="query.php">
        <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
        <input type="hidden" id="selectionRequest" name="selectionRequest">
        Show the phone numbers of all workers<br />
        <p><input type="submit" value="selection" name="selection"></p>
    </form>

    <hr />

        <h2>PROJECTION</h2>

        <form method="GET" action="query.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="projectionRequest" name="projectionRequest">
            Select all the workers who have salary no less than x: <input type="text" name="salary"> <br /><br />
            <p><input type="submit" value="projection" name="projection"></p>
        </form>

        <hr />
    
    <h2>JOIN</h2>
    <form method="GET" action="query.php"> <!--refresh page when submitted-->
        <input type="hidden" id="joinRequest" name="joinRequest">
        Find the work number of cleaners that are assigned to the room with the room number of:<input type="text" name="room"> <br /><br />
        <input type="submit"  name="join"></p>
    </form>

    <hr/>

    <h2>AGGREGATION WITH GROUP BY</h2>

        <form method="GET" action="query.php">
            <input type="hidden" id="aggregationGroupByRequest" name="aggregationGroupByRequest">
            For each location, Find the number of meetings that has topic: <input type="text" name="topic"> <br /><br />
            <p><input type="submit" value="submit" name="aggregationGroupBy"></p>
        </form>

        <hr />

        <h2>AGGREGATION WITH HAVING</h2>
     

        <form method="GET" action="query.php">
            <input type="hidden" id="aggregationHavingRequest" name="aggregationHavingRequest">
            Find the total amount of money given out as bonus by each hotel where there average amount of money of each bonus is at least <input type="text" name="money">
            <p><input type="submit" value="submit" name="aggregationHaving"></p>
        </form>

        <hr />

        <h2>NESTED AGGREGATION WITH GROUPBY</h2>


        <form method="GET" action="query.php">
            <input type="hidden" id="nestedAggregationGroupByRequest" name="nestedAggregationGroupByRequest">
            Find the hotel that gives out the most money as bonus, which is decided by financial department with Address:<input type="text" name="address"> and Name: <input type="text" name="name">
            <p><input type="submit" value="submit" name="nestedAggregationGroupBy"></p>
        </form>

        <hr />

        <h2>DIVISION</h2>
    
        <form method="GET" action="query.php">
            <input type="hidden" id="divisionRequest" name="divisionRequest">
            Find the work_number of the worker who is assigned to every room with type: <input type="text" name="type">
            <p><input type="submit" value="submit" name="division"></p>
        </form>





</body>


</html>

<?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP
        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())
        function debugAlertMessage($message) {
            global $show_debug_alert_messages;
            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }
        function connectToDB() {
            global $db_conn;
            // Your username is ora_(CWL_ID) and the password is a(student number). For example, 
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_pyuke", "a78099959", "dbhost.students.cs.ubc.ca:1522/stu");
            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }
        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;
            $statement = OCIParse($db_conn, $cmdstr); 
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work
            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }
            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }
			return $statement;
		}
        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection. 
		See the sample code below for how this function is used */
			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);
            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }
            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}
                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

function handleSelectionRequest() {
    global $db_conn;
    $result = executePlainSQL("SELECT phone FROM Worker");


    echo "<br>Retrieved data from table worker:<br>";
    echo "<table>";
    echo "<tr><th>phone</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row["PHONE"] . "</td></tr>";//or just use "echo $row[0]"
    }
    echo "</table>";
}

        function handleProjectionRequest() {
            global $db_conn;
            $salary = $_GET['salary'];
            $result = executePlainSQL("SELECT * FROM Worker WHERE salary >= $salary");
 
            
            echo "<br>Retrieved data from table worker:<br>";
            echo "<table>";
            echo "<tr><th>salary</th><th>phone</th><th>work_number</th><th>Address</th><th>Hotel_Address</th><th>Hotel_Name</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["SALARY"] . "</td><td>" . $row["PHONE"] . "</td><td>" . $row["WORK_NUMBER"] . "</td><td>" . $row["ADDRESS"] . "</td><td>" . $row["HOTEL_ADDRESS"] . "</td><td>" . $row["HOTEL_NAME"] . "</td></tr>";//or just use "echo $row[0]" 
            }
            echo "</table>";
        }



    function handleJoinRequest() {
        global $db_conn;
        $room = $_GET['room']; 
        $result = executePlainSQL("SELECT Cleaner.work_number as CWN
                                  FROM Cleaner,Assign
                                  WHERE Cleaner.work_number = Assign.work_number
                                  AND Assign.room_number = $room");

        echo "<br>Retrieved work_number from table cleaner and assign:<br>";
        echo "<table>";
        echo "<tr><th>work_number</th></tr>";
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row["CWN"]  . "</td></tr>";//or just use "echo $row[0]" 
        }
        echo "</table>";
    }

    function handleAggregationGroupByRequest() {
        global $db_conn;
        $topic = $_GET['topic']; 
        $result = executePlainSQL("SELECT location, COUNT(*)
                                   FROM Meeting
                                   WHERE topic = '" . $topic . "'
                                   GROUP BY location");

        echo "<br>Retrieved data from table meeting:<br>";
        echo "<table>";
        echo "<tr><th>location</th><th>number_of_meeting</th></tr>";
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row["LOCATION"]  ."</td><td>" . $row["COUNT(*)"] . "</td></tr>";//or just use "echo $row[0]" 
        }
        echo "</table>";
    }

    function handleAggregationHavingRequest() {
        global $db_conn;
        $money = $_GET['money']; 
        $result = executePlainSQL("SELECT hotel_address, hotel_name ,SUM(amount) AS sum
                                   FROM Bonus
                                   GROUP BY hotel_address, hotel_name
                                   HAVING avg(amount) > $money");

        echo "<br>Retrieved data from table bonus:<br>";
        echo "<table>";
        echo "<tr><th>hotel_address</th><th>hotel_name</th><th>total_amount</th></tr>";
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row["HOTEL_ADDRESS"]  ."</td><td>" . $row["HOTEL_NAME"] ."</td><td>" . $row["SUM"] . "</td></tr>";//or just use "echo $row[0]"
        }
        echo "</table>";
    }

    function handleNestedAggregationGroupByRequest() {
        global $db_conn;
        $FD_address = $_GET['address']; 
        $FD_name = $_GET['name']; 
        $result = executePlainSQL("SELECT hotel_address, hotel_name ,SUM(B1.amount)
                                 FROM Bonus B1,Financial_department2 FD1
                                 WHERE FD1.address = '" . $FD_address . "'
                                 AND   FD1.name = '" . $FD_name . "'
                                 AND B1.FD_address = FD1.address
                                 AND B1.FD_name = FD1.name 
                                 GROUP BY hotel_address, hotel_name
                                 HAVING SUM(B1.amount) >= ALL(SELECT SUM(B2.amount)
                                                              FROM Bonus B2, Financial_department2 FD2 
                                                              WHERE FD2.address = '" . $FD_address . "'
                                                              AND FD2.name = '" . $FD_name . "'
                                                              AND B2.FD_address = FD2.address
                                                              AND B2.FD_name = FD2.name
                                                              GROUP BY hotel_address, hotel_name)");

        echo "<br>Retrieved data from table bonus,FD:<br>";
        echo "<table>";
        echo "<tr><th>hotel_address</th><th>hotel_name</th><th>total_amount</th></tr>";
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row["HOTEL_ADDRESS"]  ."</td><td>" . $row["HOTEL_NAME"] ."</td><td>" . $row["SUM(B1.amount))"] . "</td></tr>";//or just use "echo $row[0]" 
        }
        echo "</table>";
    }

    function handleDivisionRequest() {
        global $db_conn;
        $type= $_GET['type']; 
        $result = executePlainSQL("SELECT C.work_number as WN
                                   FROM Cleaner C
                                   WHERE NOT EXISTS((SELECT R.room_number 
                                                     FROM Room1 R
                                                     WHERE R.type = '" . $type. "')
                                   MINUS
                                        (SELECT A.room_number
                                        FROM Assign A, Room1 R
                                        WHERE A.work_number = C.work_number
                                          AND R.type = '" . $type. "'
                                          AND R.room_number = A.room_number))");

        echo "<br>Retrieved data from table cleaner:<br>";
        echo "<table>";
        echo "<tr><th>work_number</th></tr>";
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row["WN"] . "</td></tr>";//or just use "echo $row[0]" 
        }
        echo "</table>";
    }
  
      
        function handleGETRequest() {
            if (connectToDB()) {
                if(array_key_exists('projection',$_GET)) {
                    handleProjectionRequest();
                } else if(array_key_exists('selection',$_GET)) {
                    handleSelectionRequest();
                } else if(array_key_exists('join',$_GET)) {
                    handleJoinRequest();
                }else if(array_key_exists('aggregationGroupBy',$_GET)) {
                    handleAggregationGroupByRequest();
                }else if(array_key_exists('aggregationHaving',$_GET)) {
                    handleAggregationHavingRequest();
                }else if(array_key_exists('division',$_GET)) {
                    handleDivisionRequest();
                }else if(array_key_exists('nestedAggregationGroupBy',$_GET)) {
                    handleNestedAggregationGroupByRequest();
                }
    
                disconnectFromDB();
            }
        }
  
           if (isset($_GET['selectionRequest']) ||isset($_GET['projectionRequest']) || isset($_GET['joinRequest']) || isset($_GET['aggregationGroupByRequest']) || isset($_GET['aggregationHavingRequest']) || isset($_GET['divisionRequest']) ||isset($_GET['nestedAggregationGroupByRequest']) ) {
            echo "<br>Retrieved data from table bonus,FD:<br>";
            handleGETRequest();
            }
?>
