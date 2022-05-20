<html>
<head>
    <title>CPSC 304 PHP/Oracle Demonstration</title>
</head>

<body>
<a href="main.php"> Back to Main </a><br/>


<hr/>
<!-- Meeting operations !!!!!!!!!!!!!!!!!!!!! -->

<h2>Insert Values into Meeting</h2>
<form method="POST" action="meeting.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertMeetingRequest" name="insertMeetingRequest">
    Meeting_ID: <input type="text" name="meeting_ID"> <br/><br/>
    Time: <input type="text" name="time"> <br/><br/>
    Topic: <input type="text" name="topic"> <br/><br/>
    Location: <input type="text" name="location"> <br/><br/>
    <input type="submit" value="Insert" name="insertMeetingSubmit"></p>
</form>

<hr/>

<h2>Delete Values from Meeting</h2>
<form method="POST" action="meeting.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteMeetingRequest" name="deleteMeetingRequest">
    Meeting_ID: <input type="text" name="meeting_ID"> <br/><br/>
    <input type="submit" value="Delete" name="deleteMeetingSubmit"></p>
</form>


<!-- Meeting(organize) operations !!!!!!!!!!!!!!!!!!!!! -->

<h2>Insert Values into Organize</h2>
<form method="POST" action="meeting.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertOrganizeRequest" name="insertOrganizeRequest">
    Meeting_ID: <input type="text" name="meeting_ID"> <br/><br/>
    Manager_ID: <input type="text" name="manager_ID"> <br/><br/>
    <input type="submit" value="Insert" name="insertOrganizeSubmit"></p>
</form>

<hr/>

<h2>Delete Values from Organize</h2>
<form method="POST" action="meeting.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteOrganizeRequest" name="deleteOrganizeRequest">
    Meeting_ID: <input type="text" name="meeting_ID"> <br/><br/>
    Manager_ID: <input type="text" name="manager_ID"> <br/><br/>
    <input type="submit" value="Insert" name="deleteOrganizeSubmit"></p>
</form>

<hr/>

<!-- Meeting(attend) operations !!!!!!!!!!!!!!!!!!!!! -->
<h2>Insert Values into Attend</h2>
<form method="POST" action="meeting.php"> <!--refresh page when submitted-->
    <input type="hidden" id="insertAttendRequest" name="insertAttendRequest">
    Meeting_ID: <input type="text" name="meeting_ID"> <br/><br/>
    Work_Number: <input type="text" name="work_number"> <br/><br/>
    Hotel_Address: <input type="text" name="hotel_address"> <br/><br/>
    Hotel_name:<input type="text" name="hotel_name"> <br/><br/>
    <input type="submit" value="Insert" name="insertAttendSubmit"></p>
</form>

<h2>Delete Values from Attend</h2>
<form method="POST" action="meeting.php"> <!--refresh page when submitted-->
    <input type="hidden" id="deleteAttendRequest" name="deleteAttendRequest">
    Meeting_ID: <input type="text" name="meeting_ID"> <br/><br/>
    Work_Number: <input type="text" name="work_number"> <br/><br/>
    Hotel_Address: <input type="text" name="hotel_address"> <br/><br/>
    Hotel_name:<input type="text" name="hotel_name"> <br/><br/>
    <input type="submit" value="Insert" name="deleteAttendSubmit"></p>
</form>

<h2>Display the Tuples in Meeting</h2>
<form method="GET" action="meeting.php"> <!--refresh page when submitted-->
    <input type="hidden" id="displayMeetingRequest" name="displayMeetingRequest">
    <input type="submit" values ="Display" name="displayMeetings"></p>
</form>

<h2>Display the Tuples in Organize</h2>
<form method="GET" action="meeting.php"> <!--refresh page when submitted-->
    <input type="hidden" id="displayOrganizeRequest" name="displayOrganizeRequest">
    <input type="submit" values ="Display" name="displayOrganizes"></p>
</form>

<h2>Display the Tuples in Attend</h2>
<form method="GET" action="meeting.php"> <!--refresh page when submitted-->
    <input type="hidden" id="displayAttendRequest" name="displayAttendRequest">
    <input type="submit" values ="Display" name="displayAttends"></p>
</form>

<?php
//this tells the system that it's no longer just parsing html; it's now parsing PHP
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = NULL; // edit the login credentials in connectToDB()
$show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())
function debugAlertMessage($message)
{
    global $show_debug_alert_messages;
    if ($show_debug_alert_messages) {
        echo "<script type='text/javascript'>alert('" . $message . "');</script>";
    }
}
function executePlainSQL($cmdstr)
{ //takes a plain (no bound variables) SQL command and executes it
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
function executeBoundSQL($cmdstr, $list)
{
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
function connectToDB()
{
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
function disconnectFromDB()
{
    global $db_conn;
    debugAlertMessage("Disconnect from Database");
    OCILogoff($db_conn);
}

function handleInsertMeetingRequest()
{
    global $db_conn;
    //Getting the values from user and insert data into the table
    $tuple = array(
        ":mt_id" => $_POST['meeting_ID'],
        ":mt_time" => $_POST['time'],
        ":mt_topic" => $_POST['topic'],
        ":mt_location" => $_POST['location']
    );
    $alltuples = array(
        $tuple
    );
    executeBoundSQL("insert into Meeting values (:mt_id, :mt_time,:mt_topic,:mt_location)", $alltuples);
    OCICommit($db_conn);
}
function handleDeleteMeetingRequest()
{
    global $db_conn;
    //Getting the values from user
    $tuple = array(
        ":mt_id" => $_POST['meeting_ID'],
    );
    $alltuples = array(
        $tuple
    );
    executeBoundSQL("delete from Meeting where meeting_ID = :mt_id", $alltuples);
    OCICommit($db_conn);
}
function handleInsertOrganizeRequest()
{
    global $db_conn;
    //Getting the values from user and insert data into the table
    $tuple = array(
        ":o_wn" => $_POST['meeting_ID'],
        ":o_mid" => $_POST['manager_ID'],
    );
    $alltuples = array(
        $tuple
    );
    executeBoundSQL("insert into Organize values (:o_wn, :o_mid)", $alltuples);
    OCICommit($db_conn);
}
function handleDeleteOrganizeRequest()
{
    global $db_conn;
    //Getting the values from user
    $tuple = array(
        ":o_wn" => $_POST['meeting_ID'],
        ":o_mid" => $_POST['manager_ID'],
    );
    $alltuples = array(
        $tuple
    );
    executeBoundSQL("delete from Organize where meeting_ID = :o_wn and manager_ID = :o_mid)", $alltuples);
    OCICommit($db_conn);
}
function handleInsertAttendRequest()
{
    global $db_conn;
    //Getting the values from user and insert data into the table
    $tuple = array(
        ":att_wn" => $_POST['work_number'],
        ":att_mid" => $_POST['meeting_ID'],
        ":att_ha" => $_POST["hotel_address"],
        ":att_hn" => $_POST["hotel_name"],
    );
    $alltuples = array(
        $tuple
    );
    executeBoundSQL("insert into Attend values (:att_wn, :att_mid, :att_ha, att:hn)", $alltuples);
    OCICommit($db_conn);
}
function handleDeleteAttendRequest()
{
    global $db_conn;
    //Getting the values from user and insert data into the table
    $tuple = array(
        ":att_wn" => $_POST['work_number'],
        ":att_mid" => $_POST['meeting_ID'],
        ":att_ha" => $_POST["hotel_address"],
        ":att_hn" => $_POST["hotel_name"],
    );
    $alltuples = array(
        $tuple
    );
    executeBoundSQL("delete from Attend where work_number = :att_wn and meeting_ID = :att_mid 
                     and hotel_address = :att_ha and hotel_name = :att_hn ", $alltuples);
    OCICommit($db_conn);
}
function handleDisplayMeetingRequest() {
    global $db_conn;
    $result = executePlainSQL("SELECT * FROM Meeting");
    //prints results from a select statement
    echo "<br>Retrieved data from Meeting:<br>";
    echo "<table>";
    echo "<tr><th>meeting_ID</th><th>time</th><th>topic</th><th>location</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>"; //or just use "echo $row[0]"
    }
    echo "</table>";
}
function handleDisplayOrganizeRequest() {
    global $db_conn;
    $result = executePlainSQL("SELECT * FROM Organize");
    //prints results from a select statement
    echo "<br>Retrieved data from Organize:<br>";
    echo "<table>";
    echo "<tr><th>meeting_ID</th><th>manager_ID</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
    }
    echo "</table>";
}
function handleDisplayAttendRequest() {
    global $db_conn;
    $result = executePlainSQL("SELECT * FROM Attend");
    //prints results from a select statement
    echo "<br>Retrieved data from Attend:<br>";
    echo "<table>";
    echo "<tr><th>work_number</th><th>meeting_ID</th><th>hotel_address</th><th>hotel_name</th></tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>";
    }
    echo "</table>";
}
// HANDLE ALL POST ROUTES
// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
function handlePOSTRequest()
{
    if (connectToDB()) {
        if (array_key_exists('insertMeetingRequest', $_POST)) {
            handleInsertMeetingRequest();
        } else if (array_key_exists('deleteMeetingRequest', $_POST)) {
            handleDeleteMeetingRequest();
        } else if (array_key_exists('insertOrganizeRequest', $_POST)) {
            handleInsertOrganizeRequest();
        } else if (array_key_exists('deleteOrganizeRequest', $_POST)) {
            handleDeleteOrganizeRequest();
        } else if (array_key_exists('insertAttendRequest', $_POST)) {
            handleInsertAttendRequest();
        } else if (array_key_exists('deleteAttendRequest', $_POST)) {
            handleDeleteAttendRequest();
        }
        disconnectFromDB();
    }
}
// HANDLE ALL GET ROUTES
// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
function handleGETRequest()
{
    if (connectToDB()) {
        if (array_key_exists('displayMeetingRequest', $_GET)) {
            handleDisplayMeetingRequest();
        } else if (array_key_exists('displayOrganizeRequest', $_GET)) {
            handleDisplayOrganizeRequest();
        } else if (array_key_exists('displayAttendRequest', $_GET)) {
            handleDisplayAttendRequest();
        }
        disconnectFromDB();
    }
}
if (isset($_POST['insertMeetingSubmit']) || isset($_POST['deleteMeetingSubmit'])
    || isset($_POST['insertOrganizeSubmit']) || isset($_POST['deleteOrganizeSubmit'])
    || isset($_POST['insertAttendSubmit']) || isset($_POST['deleteAttendSubmit'])) {
    handlePOSTRequest();
} else if (isset($_GET['displayAttends']) || isset($_GET['displayMeetings']) || isset($_GET['displayOrganizes'])) {
    handleGETRequest();
}
?>
</body>
</html>
