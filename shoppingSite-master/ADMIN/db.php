
<?php
function OpenCon()
 {
  $dbhost =   "localhost";
  $dbuser =   "";/*Enter your host username */
  $dbpass =   "";/*If there is one enter your host password */
  $db =   "lastikbank";/*Enter your database name */
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   /*
try {
    $db = new PDO("mysql:host=localhost;dbname=lastikbank;charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch ( PDOException $e ){
    print $e->getMessage();
}

<?php
include 'db.php';
$conn = OpenCon();
echo "Connected Successfully";
CloseCon($conn);
?>


*/
?>
