<?php
include "/config/db.php";

/*
class Image extends \chief725\models\Image {
	public static function createImage($parcel_id) {
		$image = new static ();
		$image->parcel_id = $parcel_id;
		$image->save ();
		return $image;
	}
	public function getParcel() {
		return $this::hasOne ( Parcel::className (), [
				"id" => "parcel_id"
		] );
	}
}
class Image extends \yii\db\ActiveRecord{
	
	public static function tableName()
	{
		return 'image';
	}
	public function attributeLabels()
	{
		return [
				'id' => 'ID',
				'parcel_id' => 'Parcel_ID',
				'image' => 'image',
				'timestamp' => 'Timestamp',
		];
	}

}*/

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, firstname, lastname FROM MyGuests";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Name</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["firstname"]." ".$row["lastname"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>