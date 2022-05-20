<html>
    <head>
        <title>CPSC 304 PHP/Oracle Demonstration</title>
    </head>

    <body>
    <a href="main.php"> Back to Main </a><br/>

 <!-- Worker operations !!!!!!!!!!!!!!!!!!!!! -->
<h2>Insert Values into Worker</h2>
<form method="POST" action="worker.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertWorkerRequest" name="insertWorkerRequest">
    Work_Number: <input type="text" name="work_number"> <br /><br />
    Address: <input type="text" name="address"> <br /><br />
    Phone: <input type="text" name="phone"> <br /><br />
    Salary: <input type="text" name="salary"> <br /><br />
    Hotel_Address: <input type="text" name="hotel_address"> <br /><br />
    Hotel_name:<input type="text" name="hotel_name"> <br /><br />

    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<hr/>
<h2>Insert Values into Worker(cleaner)</h2>
<form method="POST" action="worker.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertCleanerRequest" name="insertCleanerRequest">
    Work_Number: <input type="text" name="work_number"> <br /><br />
    Address: <input type="text" name="address"> <br /><br />
    Phone: <input type="text" name="phone"> <br /><br />
    Salary: <input type="text" name="salary"> <br /><br />
    Hotel_Address: <input type="text" name="hotel_address"> <br /><br />
    Hotel_name:<input type="text" name="hotel_name"> <br /><br />
    Cleanning_Kit:<input type="text" name="cleanning_kit"> <br /><br />

    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<hr/>
<h2>Insert Values into Worker(server)</h2>
<form method="POST" action="worker.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertServerRequest" name="insertServerRequest">
    Work_Number: <input type="text" name="work_number"> <br /><br />
    Address: <input type="text" name="address"> <br /><br />
    Phone: <input type="text" name="phone"> <br /><br />
    Salary: <input type="text" name="salary"> <br /><br />
    Hotel_Address: <input type="text" name="hotel_address"> <br /><br />
    Hotel_name:<input type="text" name="hotel_name"> <br /><br />
    Service_Description:<input type="text" name="service_description"> <br /><br />

    <input type="submit" value="Insert" name="insertSubmit"></p>
</form>

<hr/>

<h2>Delete Worker(including cleaner and server)</h2>
<form method="POST" action="worker.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteWorkerRequest" name="deleteWorkerRequest">
    Work_Number: <input type="text" name="work_number"> <br /><br />
    Hotel_Address: <input type="text" name="hotel_address"> <br /><br />
    Hotel_name:<input type="text" name="hotel_name"> <br /><br />
    <input type="submit" value="Delete" name="deleteSubmit"></p>
</form>

<hr />

<h2>Update Phone in Worker(including cleaner and server)</h2>
<p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

<form method="POST" action="worker.php"> <!--refresh page when submitted-->
    <input type="hidden" id="updateWorkerPhoneRequest" name="updateWorkerPhoneRequest">
    Old Phone: <input type="text" name="oldPhone"> <br /><br />
    New Phone: <input type="text" name="newPhone"> <br /><br />

    <input type="submit" value="Update" name="updateSubmit"></p>
</form>

<hr />

<h2>Update Salary in Worker(including cleaner and server)</h2>
<p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

<form method="POST" action="worker.php"> <!--refresh page when submitted-->
    <input type="hidden" id="updateWorkerSalaryRequest" name="updateWorkerSalaryRequest">
    Old Salary: <input type="text" name="oldSalary"> <br /><br />
    New Salary: <input type="text" name="newSalary"> <br /><br />

    <input type="submit" value="Update" name="updateSubmit"></p>
</form>

<hr/>

<h2>Update Address in Worker(including cleaner and server)</h2>
<p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

<form method="POST" action="worker.php"> <!--refresh page when submitted-->
    <input type="hidden" id="updateWorkerAddressRequest" name="updateWorkerAddressRequest">
    Old Address: <input type="text" name="oldAddress"> <br /><br />
    New Address: <input type="text" name="newAddress"> <br /><br />

    <input type="submit" value="Update" name="updateSubmit"></p>
</form>

<h2>Display the Tuples in  worker</h2>
        <form method="GET" action="worker.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displayWorkerTableRequest" name="displayWorkerTableRequest">
            <input type="submit"  name="displayWorkerTable"></p>
        </form>

        <hr/>

        <h2>Display the Tuples in  cleaner</h2>
        <form method="GET" action="worker.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displayCleanerTableRequest" name="displayCleanerTableRequest">
            <input type="submit"  name="displayCleanerTable"></p>
        </form>

        <hr/>

        <h2>Display the Tuples in  server</h2>
        <form method="GET" action="worker.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displayServerTableRequest" name="displayServerTableRequest">
            <input type="submit"  name="displayServerTable"></p>
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
        function printWorkerResult($result) { //prints results from a select statement
            echo "<br>Retrieved data from table worker:<br>";
            echo "<table>";
            echo "<tr><th>salary</th><th>phone</th><th>work_number</th><th>Address</th><th>Hotel_Address</th><th>Hotel_Name</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["SALARY"] . "</td><td>" . $row["PHONE"] . "</td><td>" . $row["WORK_NUMBER"] . "</td><td>" . $row["ADDRESS"] . "</td><td>" . $row["HOTEL_ADDRESS"] . "</td><td>" . $row["HOTEL_NAME"] . "</td></tr>";//or just use "echo $row[0]" 
            }
            echo "</table>";
        }
        function printCleanerResult($result) { //prints results from a select statement
            echo "<br>Retrieved data from table cleaner:<br>";
            echo "<table>";
            echo "<tr><th>work_number</th>><th>Hotel_Address</th><th>Hotel_Name</th><th>Cleanning_Kit</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["WORK_NUMBER"] . "</td><td>"  . $row["HOTEL_ADDRESS"] . "</td><td>" . $row["HOTEL_NAME"] . "</td><td>" . $row["CLEANNING_KIT"] . "</td></tr>";//or just use "echo $row[0]" 
            }
            echo "</table>";
        }
        function printServerResult($result) { //prints results from a select statement
            echo "<br>Retrieved data from table server:<br>";
            echo "<table>";
            echo "<tr><th>work_number</th>><th>Hotel_Address</th><th>Hotel_Name</th><th>Service_Description</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["WORK_NUMBER"] . "</td><td>"  . $row["HOTEL_ADDRESS"] . "</td><td>" . $row["HOTEL_NAME"] . "</td><td>" . $row["SERVICE_DESCRIPTION"] . "</td></tr>";//or just use "echo $row[
            }
            echo "</table>";
        }
        function disconnectFromDB() {
            global $db_conn;
            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }
        function handleUpdateWorkerSalaryRequest() {
            global $db_conn;
            $old_salary = $_POST['oldSalary'];
            $new_salary = $_POST['newSalary'];
            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("UPDATE Worker SET salary='" . $new_salary . "' WHERE salary='" . $old_salary . "'");
            OCICommit($db_conn);
        }
        function handleUpdateWorkerPhoneRequest() {
            global $db_conn;
            $old_phone = $_POST['oldPhone'];
            $new_phone = $_POST['newPhone'];
            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("UPDATE Worker SET phone='" . $new_phone . "' WHERE phone='" . $old_phone . "'");
            OCICommit($db_conn);
        }
        function handleUpdateWorkerAddressRequest() {
            global $db_conn;
            $old_address = $_POST['oldAddress'];
            $new_address = $_POST['newAddress'];
            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("UPDATE Worker SET address'" . $new_address . "' WHERE address='" . $old_address . "'");
            OCICommit($db_conn);
        }
        function handleDeleteWorkerRequest() {
            global $db_conn;
            $to_be_delete = $_POST['workerID'];
            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("DELETE FROM Worker WHERE workerID= '". $to_be_delete. "' " );
            OCICommit($db_conn);
        }

        function handleInsertRequest() {
            global $db_conn;
            //Getting the values from user and insert data into the table
            $tuple = array (
                ":bind1" => $_POST['work_number'],
                ":bind2" => $_POST['address'],
                ":bind3" => $_POST['phone'],
                ":bind4" => $_POST['salary'],
                ":bind5" => $_POST['hotel_address'],
                ":bind6" => $_POST['hotel_name']
            );
            $alltuples = array (
                $tuple
            );
            executeBoundSQL("insert into Worker values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6)", $alltuples);
            OCICommit($db_conn);
        }
        function handleInsertCleanerRequest() {
            global $db_conn;
            //Getting the values from user and insert data into the table
            $tuple = array (
                ":bind1" => $_POST['work_number'],
                ":bind2" => $_POST['address'],
                ":bind3" => $_POST['phone'],
                ":bind4" => $_POST['salary'],
                ":bind5" => $_POST['hotel_address'],
                ":bind6" => $_POST['hotel_name']
            );
            $tuple2 = array (
                ":bind7" => $_POST['work_number'],
                ":bind8" => $_POST['hotel_address'],
                ":bind9" => $_POST['hotel_name'],
                ":bind10" => $_POST['cleanning_kit']
            );
            $alltuples = array (
                $tuple
            );
            $alltuples2 = array (
                $tuple2
            );
            executeBoundSQL("insert into Worker values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6)", $alltuples);
            executeBoundSQL("insert into Cleaner values (:bind7, :bind8, :bind9, :bind10)", $alltuples2);
         
            OCICommit($db_conn);
        }
        function handleInsertServerRequest() {
            global $db_conn;
            //Getting the values from user and insert data into the table
            $tuple = array (
                ":bind1" => $_POST['work_number'],
                ":bind2" => $_POST['address'],
                ":bind3" => $_POST['phone'],
                ":bind4" => $_POST['salary'],
                ":bind5" => $_POST['hotel_address'],
                ":bind6" => $_POST['hotel_name']
            );
            $tuple2 = array (
                ":bind7" => $_POST['work_number'],
                ":bind8" => $_POST['hotel_address'],
                ":bind9" => $_POST['hotel_name'],
                ":bind10" => $_POST['service_description']
            );
            $alltuples = array (
                $tuple
            );
            $alltuples2 = array (
                $tuple2
            );
            executeBoundSQL("insert into Worker values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6)", $alltuples);
            executeBoundSQL("insert into Server values (:bind7, :bind8, :bind9, :bind10)", $alltuples2);
         
            OCICommit($db_conn);
        }
        function handleDisplayWorkerRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT * FROM Worker");
            
                printWorkerResult($result);
            
        }
        function handleDisplayCleanerRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT * FROM Cleaner");
            
                printCleanerResult($result);
            
        }
        function handleDisplayServerRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT * FROM Server");
            
                printServerResult($result);
            
        }
           // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handleGETRequest() {
        if (connectToDB()) {
            if(array_key_exists('displayWorkerTable',$_GET)) {
                handleDisplayWorkerRequest();
            } else if(array_key_exists('displayCleanerTable',$_GET)) {
                handleDisplayCleanerRequest();
            }else if(array_key_exists('displayServerTable',$_GET)) {
                handleDisplayServerRequest();
            }
            disconnectFromDB();
        }
    }
    function handlePOSTRequest() {
        if (connectToDB()) {
            if (array_key_exists('updateWorkerPhoneRequest', $_POST)) {
                handleUpdateWorkerPhoneRequest();
            } else if (array_key_exists('updateWorkerAddressRequest', $_POST)) {
                handleUpdateWorkerAddressRequest();
            }else if (array_key_exists('updateWorkerSalaryRequest', $_POST)) {
                handleUpdateWorkerSalaryRequest();
            }else if (array_key_exists('insertWorkerRequest', $_POST)) {
                handleInsertRequest();
            }else if (array_key_exists('deleteWorkerRequest', $_POST)) {
                handleDeleteWorkerRequest();
            }else if (array_key_exists('insertCleanerRequest', $_POST)) {
                handleInsertCleanerRequest();
            }else if (array_key_exists('insertServerRequest', $_POST)) {
                handleInsertServerRequest();
            }
            disconnectFromDB();
        }
    }
        if (isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])  || isset($_POST['deleteSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['displayWorkerTableRequest']) || isset($_GET['displayCleanerTableRequest']) || isset($_GET['displayServerTableRequest']) ) {
            handleGETRequest();
        }
?>
