<html>

<head>

    <title>project main page</title>
</head>

<body>

<a href="manager.php" target="_self" title="managemanager">manage manager</a><br/>
<a href="worker.php" target="_self" title="manageworker">manage worker</a><br/>
<a href="meeting.php" target="_self" title="manageworker">manage meeting</a><br/>
<a href="bonus.php" target="_self" title="manageworker">manage bonus</a><br/>
<a href="car.php" target="_self" title="manageworker">manage car</a><br/>
<a href="assign.php" target="_self" title="manageworker">assign cleaner</a><br/>
<a href="query.php" target="_self" title="query">query</a><br/>

        <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="main.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

        <hr />
    
    <h2>Display the Tuples in  Hotel</h2>
    <form method="GET" action="main.php"> <!--refresh page when submitted-->
        <input type="hidden" id="displayHotelTableRequest" name="displayHotelTableRequest">
        <input type="submit"  name="displayHotelTable"></p>
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
   
        function printHotelResult($result) { //prints results from a select statement
            echo "<br>Retrieved data from Hotel:<br>";
            echo "<table>";
            echo "<tr><th>Address</th><th>Name</th><th>Phone</th><th>FD_Address</th><th>FD_Name</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["ADDRESS"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["PHONE"] . "</td><td>" . $row["FD_ADDRESS"] ."</td><td>". $row["FD_NAME"] . "</td></tr>";//or just use "echo $row[0]" 
            }
            echo "</table>";
        }
        function printAddressZIPCodeResult($result) { //prints results from a select statement
            echo "<br>Retrieved data from AdddressZIPCode:<br>";
            echo "<table>";
            echo "<tr><th>Address</th><th>ZIP_code</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["ADDRESS"] . "</td><td>" . $row["ZIP_CODE"] ."</td></tr>";//or just use "echo $row[0]" 
            }
            echo "</table>";
        }
        function handleHotelDisplayRequest() {
            global $db_conn;
            $result1 = executePlainSQL("SELECT * FROM Hotel");
            $result2 = executePlainSQL("SELECT * FROM AddressZIPCode");
            
                printHotelresult($result1);
                printAddressZIPCodeResult($result2);
            
        }
        function printFD1Result($result) { //prints results from a select statement
            echo "<br>Retrieved data from FD1:<br>";
            echo "<table>";
            echo "<tr><th>Address</th><th>ZIP_code</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["ADDRESS"] . "</td><td>" . $row["ZIP_CODE"] . "</td></tr>";//or just use "echo $row[0]" 
            }
            echo "</table>";
        }
        function printFD2Result($result) { //prints results from a select statement
            echo "<br>Retrieved data from FD2:<br>";
            echo "<table>";
            echo "<tr><th>Address</th><th>phone</th><th>name</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["ADDRESS"] . "</td><td>" . $row["ZIP_CODE"] ."</td><td>" . $row["NAME"] ."</td></tr>";//or just use "echo $row[0]" 
            }
            echo "</table>";
        }
        function handleFDDisplayRequest() {
            global $db_conn;
            $result1 = executePlainSQL("SELECT * FROM Financial_department1");
            $result2 = executePlainSQL("SELECT * FROM Financial_department2");
            
                printFD1result($result1);
                printFD2Result($result2);
            
        }
        function printRoom1Result($result) { //prints results from a select statement
            echo "<br>Retrieved data from Room1:<br>";
            echo "<table>";
            echo "<tr><th>room_number</th><th>type</th><th>hotel_address</th><th>gotel_name</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["ROOM_NUMBER"] . "</td><td>" . $row["TYPE"] . "</td><td>" . $row["HOTEL_ADDRESS"] ."</td><td>" . $row["HOTEL_NAME"] ."</td></tr>";//or just use "echo $row[0]" 
            }
            echo "</table>";
        }
        function printRoom2Result($result) { //prints results from a select statement
            echo "<br>Retrieved data from Room2:<br>";
            echo "<table>";
            echo "<tr><th>price</th><th>type</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["PRICE"] . "</td><td>" . $row["TYPE"] . "</td></tr>";//or just use "echo $row[0]" 
            }
            echo "</table>";
        }
        function handleRoomDisplayRequest() {
            global $db_conn;
            $result1 = executePlainSQL("SELECT * FROM Room1");
            $result2 = executePlainSQL("SELECT * FROM Room2");
            
                printRoom1result($result1);
                printRoom2Result($result2);
            
        }
     
        function handleProvideDisplayRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT * FROM Provide");
            echo "<br>Retrieved data from Provide:<br>";
            echo "<table>";
            echo "<tr><th>parking_address</th><th>hotel_address</th><th>hotel_name</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["PARKING_ADDRESS"] . "</td><td>" . $row["HOTEL_ADDRESS"] . "</td><td>" . $row["HOTEL_NAME"] ."</td></tr>";//or just use "echo $row[0]" 
            }
            echo "</table>";
    
            
        }
        function handleResetRequest() {
            global $db_conn;
            // Drop old table
            executePlainSQL("DROP TABLE Provide");
            executePlainSQL("DROP TABLE Assign");
            executePlainSQL("DROP TABLE Attend");
            executePlainSQL("DROP TABLE Bonus");
            executePlainSQL("DROP TABLE Car");
            executePlainSQL("DROP TABLE Parking_Lot");
            executePlainSQL("DROP TABLE Organize");
            executePlainSQL("DROP TABLE Manager");
            executePlainSQL("DROP TABLE Meeting");
            executePlainSQL("DROP TABLE Room1");
            executePlainSQL("DROP TABLE Room2");
            executePlainSQL("DROP TABLE Cleaner");
            executePlainSQL("DROP TABLE Server");
            executePlainSQL("DROP TABLE Worker");
            executePlainSQL("DROP TABLE Hotel");
            executePlainSQL("DROP TABLE AddressZIPCode");
            executePlainSQL("DROP TABLE Financial_department1");
            executePlainSQL("DROP TABLE Financial_department2");
            // Create new table
            echo "<br> creating new table <br>";
            executePlainSQL("CREATE TABLE Financial_department2( address  char(30), phone    int, name char(30), PRIMARY KEY(address, name))");
            executePlainSQL("CREATE TABLE Financial_department1( address  char(30) PRIMARY KEY, ZIP_code char(6))");
            executePlainSQL("CREATE TABLE AddressZIPCode(address char(30) PRIMARY KEY,ZIP_code char(6))");
            executePlainSQL("CREATE TABLE Hotel(address char(30),name char(30),phone  int,FD_address char(30),FD_name  char(30),PRIMARY KEY(address, name),FOREIGN KEY(FD_address,FD_name) REFERENCES Financial_department2(address,name))");
            executePlainSQL("CREATE TABLE Worker (work_number int, address char(30), phone int, salary int, hotel_address char(30), hotel_name char(30),
                            PRIMARY KEY(hotel_address, hotel_name,work_number),
                            FOREIGN KEY(hotel_address,hotel_name) REFERENCES Hotel(address, name))");
            executePlainSQL("CREATE TABLE Cleaner (work_number int, hotel_address char(30), hotel_name char(30), cleanning_kit int,
            PRIMARY KEY(hotel_address, hotel_name,work_number),
            FOREIGN KEY(hotel_address,hotel_name,work_number) REFERENCES Worker(hotel_address, hotel_name, work_number))");
            executePlainSQL("CREATE TABLE Server (work_number int, hotel_address char(30), hotel_name char(30), service_description char(30),
            PRIMARY KEY(hotel_address, hotel_name,work_number),
            FOREIGN KEY(hotel_address,hotel_name,work_number) REFERENCES Worker(hotel_address, hotel_name, work_number))");
            executePlainSQL("CREATE TABLE Room1(room_number int,type   char(20),hotel_address  char(30),hotel_name  char(30),PRIMARY KEY(hotel_address, hotel_name, room_number),FOREIGN KEY(hotel_address, hotel_name) REFERENCES  Hotel(address,name) ON DELETE CASCADE)");
            executePlainSQL("CREATE TABLE Room2(price  int,type   char(20) PRIMARY KEY)");
            executePlainSQL("CREATE TABLE Meeting (meeting_ID int PRIMARY KEY, time char(20), topic char(20), location char(30))");
            executePlainSQL("CREATE TABLE Manager (managerID int PRIMARY KEY, address char(30), phone int, salary int)");
            executePlainSQL("CREATE TABLE Organize (meeting_ID int, manager_ID int, PRIMARY KEY(meeting_ID, manager_ID),
            FOREIGN KEY(manager_ID) REFERENCES Manager(managerID),FOREIGN KEY(meeting_ID) REFERENCES Meeting(meeting_ID))");
            executePlainSQL("CREATE TABLE Parking_Lot(capacity  int, address char(30) PRIMARY KEY)");
            executePlainSQL("CREATE TABLE Car
            (plate_number          	 char(6)  	PRIMARY KEY,
             brand                   char(20),
             work_number       	     int   NOT NULL,
             hotel_address           char(30)   NOT NULL,
             hotel_name              char(20)	NOT NULL,
             parking_address     	 char(30),
             FOREIGN KEY(parking_address) REFERENCES Parking_lot(address),
             FOREIGN KEY(work_number,hotel_name, hotel_address) REFERENCES  Worker(work_number,hotel_name,hotel_address)
         )");
            executePlainSQL("CREATE TABLE Bonus
            (bonus_number            	  int	PRIMARY KEY,
             work_number               	  int,
             amount                       int,
             FD_address               	  char(30)  NOT NULL,
             FD_name   	                  char(30)  NOT NULL,
             hotel_address                char(30)  NOT NULL,
             hotel_name                   char(30)  NOT NULL,
             FOREIGN KEY(hotel_address, hotel_name) REFERENCES  Hotel(address, name)
            ON DELETE SET NULL,
            FOREIGN KEY(FD_address,FD_name) REFERENCES  Financial_department2(address, name)
            ON DELETE SET NULL
        )");
           executePlainSQL("CREATE TABLE Attend (work_number int,meeting_ID int,hotel_address char(30),hotel_name char(20),
           PRIMARY KEY(hotel_address, hotel_name, meeting_ID, work_number),
           FOREIGN KEY(work_number, hotel_address,hotel_name) REFERENCES
           Worker(work_number, hotel_address, hotel_name),
           FOREIGN KEY(meeting_ID) REFERENCES Meeting(meeting_ID))");
           
           executePlainSQL("CREATE TABLE Assign
           (hotel_address          char(30),
            hotel_name              char(30),
            work_number             int,
            room_number             int,
            room_hotel_address      char(30),
            room_hotel_name         char(30),
            PRIMARY KEY(hotel_address, hotel_name,work_number, room_number, room_hotel_address, room_hotel_name),
            FOREIGN KEY (hotel_address, hotel_name,work_number) REFERENCES Worker(hotel_address,hotel_name,work_number),
            FOREIGN KEY (room_number, room_hotel_address, room_hotel_name) REFERENCES Room1(room_number, hotel_address, hotel_name))");
            executePlainSQL("CREATE TABLE Provide
            (parking_address              	char(30),
              hotel_address               	char(30),
             hotel_name                     char(30),
             PRIMARY KEY(hotel_address, hotel_name, Parking_Address),
             FOREIGN KEY(hotel_address, hotel_name) REFERENCES  Hotel(address, name),
             FOREIGN KEY(parking_address) REFERENCES  Parking_Lot(address))
            ");
executePlainSQL("INSERT ALL 
INTO Financial_department2 VALUES ('2001 Road11', 6008009920, 'FD1') 
INTO Financial_department2 VALUES ('2003 Road12', 7007008830,'FD2') 
INTO Financial_department2 VALUES ('2005 Road13', 8006007740, 'FD3')
INTO Financial_department2 VALUES ('2005 Road13', 9005006650, 'FD4') 
INTO Financial_department2 VALUES ('2007 Road14', 1004007740, 'FD5')
INTO Financial_department2 VALUES ('2009 Road15', 2003005560, 'FD5')  
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Financial_department1 VALUES ('2001 Road11', 'ZIP211') 
INTO Financial_department1 VALUES ('2003 Road12', 'ZIP212') 
INTO Financial_department1 VALUES ('2005 Road13', 'ZIP213')
INTO Financial_department1 VALUES ('2007 Road14', 'ZIP214')
INTO Financial_department1 VALUES ('2009 Road15', 'ZIP215')  
SELECT 1 FROM DUAL");
 
 
executePlainSQL("INSERT ALL 
INTO AddressZIPCode VALUES ('1000 Roadone', 'ZIP111') 
INTO AddressZIPCode VALUES ('1002 Roadone', 'ZIP111') 
INTO AddressZIPCode VALUES ('1004 Roadtwo', 'ZIP112')
INTO AddressZIPCode VALUES ('1006 Roadthree', 'ZIP113') 
INTO AddressZIPCode VALUES ('1008 Roadfour', 'ZIP114') 
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Hotel (address, name, phone, FD_address, FD_name) VALUES ('1000 Roadone', 'H1', 961177, '2001 Road11', 'FD1') 
INTO Hotel (address, name, phone, FD_address, FD_name) VALUES ('1000 Roadone',  'H2', 962266, '2001 Road11', 'FD1')
INTO Hotel (address, name, phone, FD_address, FD_name) VALUES ('1002 Roadone',   'H3', 963355,  '2003 Road12', 'FD2')
INTO Hotel (address, name, phone, FD_address, FD_name) VALUES ('1004 Roadtwo',   'H4', 964444, '2007 Road14', 'FD5')
INTO Hotel (address, name, phone, FD_address, FD_name) VALUES ('1006 Roadthree', 'H5', 965533, '2005 Road13', 'FD3')
INTO Hotel (address, name, phone, FD_address, FD_name) VALUES ('1008 Roadfour',   'H6',  966622, '2009 Road15', 'FD5')
SELECT 1 from DUAL");
executePlainSQL("INSERT ALL 
INTO Room2 VALUES ('100','Single') 
INTO Room2 VALUES ('125','Double') 
INTO Room2 VALUES ('150','Triple')
INTO Room2 VALUES ('200','Quad') 
INTO Room2 VALUES ('300','Queen')
INTO Room2 VALUES ('350','King')  
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Room1 VALUES (102, 'Single','1000 Roadone', 'H1') 
INTO Room1 VALUES (103, 'Double','1000 Roadone', 'H1')  
INTO Room1 VALUES (101, 'Single','1000 Roadone', 'H2') 
INTO Room1 VALUES (102, 'Triple','1000 Roadone', 'H2') 
INTO Room1 VALUES (1102, 'King','1002 Roadone', 'H3')  
INTO Room1 VALUES (1202, 'Queen','1004 Roadtwo', 'H4')  
INTO Room1 VALUES (1101, 'Single','1006 Roadthree', 'H5')  
INTO Room1 VALUES (1201, 'Triple','1008 Roadfour', 'H6')  
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Parking_Lot VALUES (200,'pa1') 
INTO Parking_Lot VALUES (300,'pa2') 
INTO Parking_Lot VALUES (200,'pa3')
INTO Parking_Lot VALUES (200,'pa4') 
INTO Parking_Lot VALUES (200,'pa5')
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Provide VALUES ('pa1','1000 Roadone', 'H1') 
INTO Provide VALUES ('pa2','1000 Roadone', 'H2')
INTO Provide VALUES ('pa1','1000 Roadone', 'H2')
INTO Provide VALUES ('pa3','1002 Roadone', 'H3')
INTO Provide VALUES ('pa4','1004 Roadtwo', 'H4')
INTO Provide VALUES ('pa5','1006 Roadthree', 'H5')
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Worker VALUES (900, 'wRoadone',456788,2500, '1000 Roadone', 'H1')
INTO Worker VALUES (901, 'wRoadtwo',923448,2500, '1000 Roadone', 'H1')
INTO Worker VALUES (900, 'wRoadtwo',923548,2500, '1000 Roadone', 'H2')
INTO Worker VALUES (902, 'wRoadThree',923648, 2750,  '1000 Roadone', 'H2')
INTO Worker VALUES (900, 'wRoadThree', 923748, 2750, '1002 Roadone', 'H3')
INTO Worker VALUES (901, 'wRoadFour',923848, 2750, '1004 Roadtwo', 'H4')
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Worker VALUES (908, 'wRoadone',456987,2000, '1000 Roadone', 'H1')
INTO Worker VALUES (907, 'wRoadone',993458,2000, '1000 Roadone', 'H1')
INTO Worker VALUES (910, 'wRoadtwo',993848,2000, '1000 Roadone', 'H2')
INTO Worker VALUES (925, 'wRoadThree',993648, 2150,  '1000 Roadone', 'H2')
INTO Worker VALUES (929, 'wRoadThree', 993748, 2250, '1002 Roadone', 'H3')
INTO Worker VALUES (930, 'wRoadFour',993848, 2550, '1004 Roadtwo', 'H4')
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Cleaner VALUES (908, '1000 Roadone', 'H1',1)
INTO Cleaner VALUES (907, '1000 Roadone', 'H1',1)
INTO Cleaner VALUES (910, '1000 Roadone', 'H2',33)
INTO Cleaner VALUES (925,  '1000 Roadone', 'H2',22)
INTO Cleaner VALUES (929, '1002 Roadone', 'H3',6)
INTO Cleaner VALUES (930, '1004 Roadtwo', 'H4',666)
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Assign VALUES ('1000 Roadone', 'H1',908,102,'1000 Roadone', 'H1')
INTO Assign VALUES ('1000 Roadone', 'H1',907,103,'1000 Roadone', 'H1')
INTO Assign VALUES ('1000 Roadone', 'H2',910,101,'1000 Roadone', 'H2')
INTO Assign VALUES ('1000 Roadone', 'H2',925,102,'1000 Roadone', 'H1')
INTO Assign VALUES ('1002 Roadone', 'H3',929,1102,'1002 Roadone', 'H3')
INTO Assign VALUES ('1004 Roadtwo', 'H4',930,1202, '1004 Roadtwo', 'H4')
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Meeting VALUES (1, '2020/12/29 10:20am','dress code','location1')
INTO Meeting VALUES (2, '2020/12/30 10:20am','dress code','location1')
INTO Meeting VALUES (3, '2020/12/31 10:20am','dress code','location1')
INTO Meeting VALUES (4, '2020/12/01 10:20am','wrap-up','location1')
INTO Meeting VALUES (5, '2020/12/02 10:20am','etiquette','location1')
INTO Meeting VALUES (6, '2020/12/03 10:20am','etiquette','location2')
INTO Meeting VALUES (7, '2020/12/04 10:20am','dress code','location2')
INTO Meeting VALUES (8, '2020/12/05 10:20am','wrap-up','location2')
INTO Meeting VALUES (9, '2020/12/06 10:20am','dress code','location2')
INTO Meeting VALUES (10, '2020/12/07 10:20am','etiquette','location2')
INTO Meeting VALUES (11, '2020/12/08 10:20am','etiquette','location2')
INTO Meeting VALUES (12, '2020/12/09 10:20am','dress code','location3')
INTO Meeting VALUES (13, '2020/12/10 10:20am','etiquette','location3')
INTO Meeting VALUES (14, '2020/12/11 10:20am','wrap-up','location3')
INTO Meeting VALUES (15, '2020/12/12 10:20am','dress code','location3')
INTO Meeting VALUES (16, '2020/12/13 10:20am','dress code','location3')
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Bonus VALUES (1, 900, 200,'2001 Road11', 'FD1', '1000 Roadone', 'H2')
INTO Bonus VALUES (2, 901, 500,'2003 Road12', 'FD2', '1000 Roadone', 'H1')
INTO Bonus VALUES (3, 901, 250,'2005 Road13', 'FD3', '1004 Roadtwo', 'H4')
INTO Bonus VALUES (4, 902, 300,'2005 Road13', 'FD4', '1000 Roadone', 'H2')
INTO Bonus VALUES (5, 900, 700,'2007 Road14', 'FD5', '1002 Roadone', 'H3')
INTO Bonus VALUES (6, 901, 900,'2009 Road15', 'FD5', '1000 Roadone', 'H2')
INTO Bonus VALUES (7, 900, 300,'2001 Road11', 'FD1', '1000 Roadone', 'H2')
INTO Bonus VALUES (8, 900, 400,'2001 Road11', 'FD1', '1000 Roadone', 'H2')
INTO Bonus VALUES (9, 900, 500,'2001 Road11', 'FD1', '1000 Roadone', 'H2')
INTO Bonus VALUES (10, 901, 250,'2003 Road12', 'FD2', '1000 Roadone', 'H1')
INTO Bonus VALUES (11, 901, 190,'2003 Road12', 'FD2', '1000 Roadone', 'H1')
INTO Bonus VALUES (12, 901, 300,'2003 Road12', 'FD2', '1000 Roadone', 'H1')
INTO Bonus VALUES (13, 901, 400,'2003 Road12', 'FD2', '1000 Roadone', 'H1')
INTO Bonus VALUES (14, 901, 2050,'2005 Road13', 'FD3', '1004 Roadtwo', 'H4')
INTO Bonus VALUES (15, 901, 2500,'2005 Road13', 'FD3', '1004 Roadtwo', 'H4')
INTO Bonus VALUES (16, 901, 2590,'2005 Road13', 'FD3', '1004 Roadtwo', 'H4')
INTO Bonus VALUES (17, 900, 700,'2007 Road14', 'FD5', '1002 Roadone', 'H3')
INTO Bonus VALUES (18, 900, 800,'2007 Road14', 'FD5', '1002 Roadone', 'H3')
INTO Bonus VALUES (19, 900, 900,'2007 Road14', 'FD5', '1002 Roadone', 'H3')
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Worker VALUES (999, 'wRoadone',456987,2000, '1000 Roadone', 'H1')
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Cleaner VALUES (999,'1000 Roadone', 'H1',999)
SELECT 1 FROM DUAL");
executePlainSQL("INSERT ALL 
INTO Assign VALUES ('1000 Roadone', 'H1',999,102,'1000 Roadone', 'H1')
INTO Assign VALUES ('1000 Roadone', 'H1',999,103,'1000 Roadone', 'H1')
INTO Assign VALUES ('1000 Roadone', 'H1',999,101,'1000 Roadone', 'H2')
INTO Assign VALUES ('1000 Roadone', 'H1',999,102,'1000 Roadone', 'H2')
INTO Assign VALUES ('1000 Roadone', 'H1',999,1102,'1002 Roadone', 'H3')
INTO Assign VALUES ('1000 Roadone', 'H1',999,1202, '1004 Roadtwo', 'H4')
INTO Assign VALUES ('1000 Roadone', 'H1',999,1101, '1006 Roadthree', 'H5')
INTO Assign VALUES ('1000 Roadone', 'H1',999,1201, '1008 Roadfour', 'H6')
SELECT 1 FROM DUAL");







            OCICommit($db_conn);
}
        function handleGETRequest() {
            if (connectToDB()) {
                echo "<br>Retrieved data from initialized tables:<br>";
                if(array_key_exists('displayHotelTableRequest',$_GET)) {
                    handleHotelDisplayRequest();
                    handleFDDisplayRequest();
                    handleRoomDisplayRequest();
                    handleProvideDisplayRequest();
                }
    
                disconnectFromDB();
            }
        }
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
   
                    handleResetRequest();
                } 
    
                disconnectFromDB();
            }
        }
            if (isset($_POST['reset'])) {
                handlePOSTRequest();
            } else if (isset($_GET['displayHotelTableRequest'])) {
                handleGETRequest();
            }
?>
