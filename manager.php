<html>
    <head>
        <title>CPSC 304 PHP/Oracle Demonstration</title>
    </head>

    <body>
    <a href="main.php"> Back to Main </a><br/>

        <!--manager  operations!!!!!!!!!!!!!!!!!!!!!!-->
        <hr />

        <h2>Insert Values into Manager</h2>
        <form method="POST" action="manager.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertManagerRequest" name="insertManagerRequest">
            Salary: <input type="text" name="salary"> <br /><br />
            Phone: <input type="text" name="phone"> <br /><br />
            Manager_ID: <input type="text" name="managerID"> <br /><br />
            Address: <input type="text" name="address"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr/>

        <h2>Delete Values from Manager</h2>
        <form method="POST" action="manager.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteManagerRequest" name="deleteManagerRequest">
            Manager_ID: <input type="text" name="managerID"> <br /><br />
            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <hr />

        <h2>Update Phone in Manager</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="manager.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateManagerPhoneRequest" name="updateManagerPhoneRequest">
            Old Phone: <input type="text" name="oldPhone"> <br /><br />
            New Phone: <input type="text" name="newPhone"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <h2>Update Salary in Manager</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="manager.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateManagerSalaryRequest" name="updateManagerSalaryRequest">
            Old Salary: <input type="text" name="oldSalary"> <br /><br />
            New Salary: <input type="text" name="newSalary"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr/>

        <h2>Update Address in Manager</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="manager.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateManagerAddressRequest" name="updateManagerAddressRequest">
            Old Address: <input type="text" name="oldAddress"> <br /><br />
            New Address: <input type="text" name="newAddress"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />
    
        <h2>Display the Tuples in  manager</h2>
        <form method="GET" action="manager.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displayTableRequest" name="displayTableRequest">
            <input type="submit"  name="displayTable"></p>
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
        function printResult($result) { //prints results from a select statement
            echo "<br>Retrieved data from table manager:<br>";
            echo "<table>";
            echo "<tr><th>salary</th><th>phone</th><th>manager_ID</th><th>Address</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["SALARY"] . "</td><td>" . $row["PHONE"] . "</td><td>" . $row["MANAGERID"] . "</td><td>" . $row["ADDRESS"] . "</td></tr>";//or just use "echo $row[0]" 
            }
            echo "</table>";
        }
        function disconnectFromDB() {
            global $db_conn;
            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }
        function handleUpdateManagerSalaryRequest() {
            global $db_conn;
            $old_salary = $_POST['oldSalary'];
            $new_salary = $_POST['newSalary'];
            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("UPDATE Manager SET salary='" . $new_salary . "' WHERE salary='" . $old_salary . "'");
            OCICommit($db_conn);
        }
        function handleUpdateManagerPhoneRequest() {
            global $db_conn;
            $old_phone = $_POST['oldPhone'];
            $new_phone = $_POST['newPhone'];
            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("UPDATE Manager SET phone='" . $new_phone . "' WHERE phone='" . $old_phone . "'");
            OCICommit($db_conn);
        }
        function handleUpdateManagerAddressRequest() {
            global $db_conn;
            $old_address = $_POST['oldAddress'];
            $new_address = $_POST['newAddress'];
            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("UPDATE Manager SET address'" . $new_address . "' WHERE address='" . $old_address . "'");
            OCICommit($db_conn);
        }

        function handleDeleteManagerRequest() {
            global $db_conn;
            $to_be_delete = $_POST['managerID'];
            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("DELETE FROM Manager WHERE managerID=  $to_be_delete " );
            OCICommit($db_conn);
        }

        function handleInsertRequest() {
            global $db_conn;
            //Getting the values from user and insert data into the table
            $tuple = array (
                ":bind1" => $_POST['managerID'],
                ":bind2" => $_POST['address'],
                ":bind3" => $_POST['phone'],
                ":bind4" => $_POST['salary']
            );
            $alltuples = array (
                $tuple
            );
            executeBoundSQL("insert into Manager values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
            OCICommit($db_conn);
        }
        function handleDisplayRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT * FROM Manager");
            
                printResult($result);
            
        }
           // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handleGETRequest() {
        if (connectToDB()) {
            if(array_key_exists('displayTable',$_GET)) {
                handleDisplayRequest();
            }
            disconnectFromDB();
        }
    }
    function handlePOSTRequest() {
        if (connectToDB()) {
            if (array_key_exists('updateManagerPhoneRequest', $_POST)) {
                handleUpdateManagerPhoneRequest();
            } else if (array_key_exists('updateManagerAddressRequest', $_POST)) {
                handleUpdateManagerAddressRequest();
            }else if (array_key_exists('updateManagerSalaryRequest', $_POST)) {
                handleUpdateManagerSalaryRequest();
            }else if (array_key_exists('insertManagerRequest', $_POST)) {
                handleInsertRequest();
            }else if (array_key_exists('deleteManagerRequest', $_POST)) {
                handleDeleteManagerRequest();
            }
            disconnectFromDB();
        }
    }
        if (isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])  || isset($_POST['deleteSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['displayTableRequest'])) {
            handleGETRequest();
        }
?>
