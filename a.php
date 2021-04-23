<!DOCTYPE html> 
<html> 
      
<head> 
    <title> 
        Page a
    </title> 
</head> 
  
<body style="text-align:center;"> 
      
    <h1 style="color:blue;"> 
        Page a
    </h1> 
      
    <h4> 
    </h4> 

<?php
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "kaan_topcu";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } 

    $sql = "SELECT cities.c_name FROM CITIES";
    $result = mysqli_query($conn,$sql) or die("Error");

    if (mysqli_num_rows($result) > 0) {
        echo "<form action='' method='post'>";
        echo '<select name="cityname">';
        while($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row["c_name"] . "'>";
            echo $row["c_name"];
            echo "</option>";
        }
        echo '</select>';
        echo '<input type="submit" value="show">';
        echo "</form>";
    } else {
        echo "0 results";
    }

    $sql = "SELECT cities.c_name,markets.m_name,count(p_id) AS salequantity FROM sales
            JOIN salesmen
            ON sales.s_id = salesmen.s_id
            JOIN markets
            ON salesmen.m_id = markets.m_id
            JOIN cities
            ON cities.c_id = markets.c_id ";
    $sql .= "where cities.c_name = '" . $_POST['cityname'] . "'" . "GROUP BY markets.m_id";             
    $result = mysqli_query($conn,$sql) or die("11");

     if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><td>cityName</td><td>marketName</td><td>Quantity</td></tr>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["c_name"]. "</td><td>" . $row["m_name"] . "</td><td>" . $row["salequantity"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }


    mysqli_close($conn);
?>

<br><br><br>

<form method="post">
        <input type="button" value="Return main page" class="homebutton" id="btnHome" 
onClick="document.location.href='main.php'" />

</form> 



</head> 
  
</html> 