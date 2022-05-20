

  <html>
    <head>
        <title>CPSC 304 PHP/Oracle Demonstration</title>
    </head>

    <body>
        <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="project.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

        <!--manager  operations!!!!!!!!!!!!!!!!!!!!!!-->
        <hr />

        <h2>Insert Values into Manager</h2>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertManagerRequest" name="insertManagerRequest">
            Salary: <input type="text" name="salary"> <br /><br />
            Phone: <input type="text" name="phone"> <br /><br />
            Manager_ID: <input type="text" name="managerID"> <br /><br />
            Address: <input type="text" name="address"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr/>

        <h2>Delete Values from Manager</h2>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteManagerRequest" name="deleteManagerRequest">
            Manager_ID: <input type="text" name="managerID"> <br /><br />
            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <hr />

        <h2>Update Phone in Manager</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateManagerPhoneRequest" name="updateManagerPhoneRequest">
            Old Phone: <input type="text" name="oldPhone"> <br /><br />
            New Phone: <input type="text" name="newPhone"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <h2>Update Salary in Manager</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateManagerSalaryRequest" name="updateManagerSalaryRequest">
            Old Salary: <input type="text" name="oldSalary"> <br /><br />
            New Salary: <input type="text" name="newSalary"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr/>

        <h2>Update Address in Manager</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateManagerAddressRequest" name="updateManagerAddressRequest">
            Old Address: <input type="text" name="oldAddress"> <br /><br />
            New Address: <input type="text" name="newAddress"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

      <!-- Worker operations !!!!!!!!!!!!!!!!!!!!! -->

      <hr />

<h2>Insert Values into Worker</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertWorkerRequest" name="insertWorkerRequest">
    Salary: <input type="text" name="salary"> <br /><br />
    Phone: <input type="text" name="phone"> <br /><br />
    Work_Number: <input type="text" name="work_number"> <br /><br />
    Address: <input type="text" name="address"> <br /><br />
    Hotel_Address: <input type="text" name="hotel_address"> <br /><br />
    Hotel_name:<input type="text" name="hotel_name"> <br /><br />

    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<hr/>

<h2>Delete Values from Worker</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteWorkerRequest" name="deleteWorkerRequest">
    Work_Number: <input type="text" name="work_number"> <br /><br />
    Hotel_Address: <input type="text" name="hotel_address"> <br /><br />
    Hotel_name:<input type="text" name="hotel_name"> <br /><br />
    <input type="submit" value="Delete" name="deleteSubmit"></p>
</form>

<hr />

<h2>Update Phone in Worker</h2>
<p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="updateWorkerPhoneRequest" name="updateWorkerPhoneRequest">
    Old Phone: <input type="text" name="oldPhone"> <br /><br />
    New Phone: <input type="text" name="newPhone"> <br /><br />

    <input type="submit" value="Update" name="updateSubmit"></p>
</form>

<hr />

<h2>Update Salary in Worker</h2>
<p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="updateWorkerSalaryRequest" name="updateWorkerSalaryRequest">
    Old Salary: <input type="text" name="oldSalary"> <br /><br />
    New Salary: <input type="text" name="newSalary"> <br /><br />

    <input type="submit" value="Update" name="updateSubmit"></p>
</form>

<hr/>

<h2>Update Address in Worker</h2>
<p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="updateWorkerAddressRequest" name="updateWorkerAddressRequest">
    Old Address: <input type="text" name="oldAddress"> <br /><br />
    New Address: <input type="text" name="newAddress"> <br /><br />

    <input type="submit" value="Update" name="updateSubmit"></p>
</form>

<hr />
   
      <!-- Bonus operations !!!!!!!!!!!!!!!!!!!!! -->

      <hr />

<h2>Insert Values into Bonus</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertBonusRequest" name="insertBonusRequest">
    Bonus_Number: <input type="text" name="bonus_number"> <br /><br />
    Amount: <input type="text" name="amount"> <br /><br />
    Work_Number: <input type="text" name="work_number"> <br /><br />
    FD_Address: <input type="text" name="fd_address"> <br /><br />
    FD_Name: <input type="text" name="fd_name"> <br /><br />
    Hotel_Address: <input type="text" name="hotel_address"> <br /><br />
    Hotel_name:<input type="text" name="hotel_name"> <br /><br />

    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<hr/>

<h2>Delete Values from Bonus</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteBonusRequest" name="deleteBonusRequest">
    Bonus_Number: <input type="text" name="bonus_number"> <br /><br />
    <input type="submit" value="Delete" name="deleteSubmit"></p>
</form>


<hr />
   
    <!-- Meeting operations !!!!!!!!!!!!!!!!!!!!! -->

    <h2>Insert Values into Meeing</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertMeetingRequest" name="insertMeetingRequest">
    Meeting_ID: <input type="text" name="meeting_ID"> <br /><br />
    Time: <input type="text" name="time"> <br /><br />
    Topic: <input type="text" name="topic"> <br /><br />
    Location: <input type="text" name="location"> <br /><br />
    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<hr/>

<h2>Delete Values from Meeting</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteBonusRequest" name="deleteBonusRequest">
    Meeting_ID: <input type="text" name="meeting_ID"> <br /><br />
    <input type="submit" value="Delete" name="deleteSubmit"></p>
</form>


<!-- Meeting(organize) operations !!!!!!!!!!!!!!!!!!!!! -->

<h2>Insert Values into Organize</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertOrganizeRequest" name="insertOrganizeRequest">
    Meeting_ID: <input type="text" name="meeting_ID"> <br /><br />
    Manager_ID: <input type="text" name="manager_ID"> <br /><br />
    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<hr/>

<h2>Delete Values from Organize</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteOrganizeRequest" name="deleteOrganizeRequest">
    Meeting_ID: <input type="text" name="meeting_ID"> <br /><br />
    Manager_ID: <input type="text" name="manager_ID"> <br /><br />
    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<hr/>

<!-- Meeting(attend) operations !!!!!!!!!!!!!!!!!!!!! -->
<h2>Insert Values into Attend</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertAttendRequest" name="insertAttendRequest">
    Meeting_ID: <input type="text" name="meeting_ID"> <br /><br />
    Work_Number: <input type="text" name="work_number"> <br /><br />
    Hotel_Address: <input type="text" name="hotel_address"> <br /><br />
    Hotel_name:<input type="text" name="hotel_name"> <br /><br />
    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<h2>Delete Values from Attend</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteAttendRequest" name="deleteAttendRequest">
    Meeting_ID: <input type="text" name="meeting_ID"> <br /><br />
    Work_Number: <input type="text" name="work_number"> <br /><br />
    Hotel_Address: <input type="text" name="hotel_address"> <br /><br />
    Hotel_name:<input type="text" name="hotel_name"> <br /><br />
    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<hr/>

<!-- car operations !!!!!!!!!!!!!!!!!!!!! -->
<h2>Insert Values into Car</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertCarRequest" name="insertCarRequest">
    Plate_Number: <input type="text" name="plate_number"> <br /><br />
    Brand: <input type="text" name="brand_number"> <br /><br />
    Parking_Address:<input type="text" name="parking_address"> <br /><br />
    Work_Number: <input type="text" name="work_number"> <br /><br />
    Hotel_Address: <input type="text" name="hotel_address"> <br /><br />
    Hotel_name:<input type="text" name="hotel_name"> <br /><br />
    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<hr/>

<h2>Delete Values from Car</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteCarRequest" name="deleteCarRequest">
    Plate_Number: <input type="text" name="plate_number"> <br /><br />
    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<h2>Update Parking Address in Car</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="updateParkingAddresssRequest" name="updateParkingAddresssRequest">
    Old Parking_Address: <input type="text" name="oldParkingAddress"> <br /><br />
    New Parking_Address: <input type="text" name="newParkingAddress"> <br /><br />

    <input type="submit" value="Update" name="updateSubmit"></p>
</form>


<!-- assign operations !!!!!!!!!!!!!!!!!!!!! -->

<hr/>

<h2>Insert Values into assign</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertAssignRequest" name="insertAssignRequest">
    Hotel_Address: <input type="text" name="hotel_address"> <br /><br />
    Hotel_name:<input type="text" name="hotel_name"> <br /><br />
    Work_Number: <input type="text" name="work_number"> <br /><br />
    Room_Hotel_Address: <input type="text" name="room_hotel_address"> <br /><br />
    Room_Hotel_name:<input type="text" name="room_hotel_name"> <br /><br />
    Room_number:<input type="text" name="room_number"> <br /><br />
    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<hr/>

<h2>delete Values from assign</h2>
<form method="POST" action="project.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertAssignRequest" name="insertAssignRequest">
    Hotel_Address: <input type="text" name="hotel_address"> <br /><br />
    Hotel_name:<input type="text" name="hotel_name"> <br /><br />
    Work_Number: <input type="text" name="work_number"> <br /><br />
    Room_Hotel_Address: <input type="text" name="room_hotel_address"> <br /><br />
    Room_Hotel_name:<input type="text" name="room_hotel_name"> <br /><br />
    Room_number:<input type="text" name="room_number"> <br /><br />
    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>




































        <h2>Count the Tuples in DemoTable</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples"></p>
        </form>

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

        function executePlainSQL(              ) { //takes a plain (no bound variables) SQL command and executes it
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

        function printResult($result) { //prints results from a select statement
            echo "<br>Retrieved data from table demoTable:<br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>";
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

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                }

                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest'])) {
            handleGETRequest();
        }
		?>
	</body>
</html>

