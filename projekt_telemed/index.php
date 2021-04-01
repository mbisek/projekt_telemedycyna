<!doctype html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="styles.css" type="text/css" />
    </head>
    <body>

    <h1>Temperatura w pomieszczeniu</h1>

    <?php 
    $connection = @mysqli_connect('127.0.0.1', 'root', '')
        or die('Brak połączenia z serwerem MySQL');
        $db = @mysqli_select_db($connection,'projekt_telemed')
        or die('Nie mogę połączyć się z bazą danych');
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }
    mysqli_query($connection,"SET NAMES 'utf8'");

    $dzisiaj = date("Y-m-d");

    $sql_dzisiaj = "SELECT * FROM pomiary WHERE data > DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND data <= DATE(DATE_SUB(NOW(), INTERVAL 0 DAY))";
    $sql_wczoraj = "SELECT * FROM pomiary WHERE data >= DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND data <= DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))";
    $sql_przedwczoraj = "SELECT * FROM pomiary WHERE data >= NOW() - INTERVAL 3 DAY AND data <= DATE(DATE_SUB(NOW(), INTERVAL 2 DAY))";

    $result_dzisiaj = $connection->query($sql_dzisiaj);
    $result_wczoraj = $connection->query($sql_wczoraj);
    $result_przedwczoraj = $connection->query($sql_przedwczoraj);
     
    echo "<form action='save.php' method='post' name='Post'>";
    echo "<input name='Save' type='submit' value='Zapisz do pliku'> </p>"; 

    echo "
    <table>
    <caption>Dzisiaj</caption>
    <tr>
    <th>ID</th>
    <th>Data pomiaru</th>
    <th>Godzina pomiaru</th>
    <th>Temperatura</th>
    </tr>";
    
    while($row = mysqli_fetch_array($result_dzisiaj))
    {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['data'] . "</td>";
    echo "<td>" . $row['godzina'] . "</td>";
    echo "<td>" . $row['wartosc'] . " &#x2103". "</td>";
    echo "</tr>";
    }
    echo "</table>";

    echo "
    <table>
    <caption>Wczoraj</caption>
    <tr>
    <th>ID</th>
    <th>Data pomiaru</th>
    <th>Godzina pomiaru</th>
    <th>Temperatura</th>
    </tr>";
    
    while($row = mysqli_fetch_array($result_wczoraj))
    {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['data'] . "</td>";
    echo "<td>" . $row['godzina'] . "</td>";
    echo "<td>" . $row['wartosc'] . " &#x2103". "</td>";
    echo "</tr>";
    }
    echo "</table>";

    echo "
    <table>
    <caption>Przedwczoraj</caption>
    <tr>
    <th>ID</th>
    <th>Data pomiaru</th>
    <th>Godzina pomiaru</th>
    <th>Temperatura</th>
    </tr>";
    
    while($row = mysqli_fetch_array($result_przedwczoraj))
    {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['data'] . "</td>";
    echo "<td>" . $row['godzina'] . "</td>";
    echo "<td>" . $row['wartosc'] . " &#x2103". "</td>";
    echo "</tr>";
    }
    echo "</table>";


    mysqli_close($connection);
    ?>


    </body>
</html>