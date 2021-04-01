<?php
if(isset($_POST['Save'])) 
{
    $connection = @mysqli_connect('127.0.0.1', 'root', '')
    or die('Brak połączenia z serwerem MySQL');
    $db = @mysqli_select_db($connection,'projekt_telemed')
    or die('Nie mogę połączyć się z bazą danych');
    if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    mysqli_query($connection,"SET NAMES 'utf8'");

    $sql_dzisiaj = "SELECT * FROM pomiary WHERE data > DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND data <= DATE(DATE_SUB(NOW(), INTERVAL 0 DAY))";
    $sql_wczoraj = "SELECT * FROM pomiary WHERE data >= DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND data <= DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))";
    $sql_przedwczoraj = "SELECT * FROM pomiary WHERE data >= NOW() - INTERVAL 3 DAY AND data <= DATE(DATE_SUB(NOW(), INTERVAL 2 DAY))";

    $result_dzisiaj = $connection->query($sql_dzisiaj);
    $result_wczoraj = $connection->query($sql_wczoraj);
    $result_przedwczoraj = $connection->query($sql_przedwczoraj);

    echo"Pobrano wartości z bazy do plików .txt";

    $myfile = fopen("pomiary_dzisiaj.txt", "w") or die("Unable to open file!");

        $txt = "   data    |  godzina  | wartość temperatury" . "\n";
        fwrite($myfile, $txt);
        while($row = mysqli_fetch_array($result_dzisiaj))
        {
            $txt = $row['data']. " | " .$row['godzina']. "  | " .$row['wartosc']. "\n";
            fwrite($myfile, $txt);
        }
        fclose($myfile);

    $myfile = fopen("pomiary_wczoraj.txt", "w") or die("Unable to open file!");

        $txt = "   data    |  godzina  | wartość temperatury" . "\n";
        fwrite($myfile, $txt);
        while($row = mysqli_fetch_array($result_wczoraj))
        {
            $txt = $row['data']. " | " .$row['godzina']. "  | " .$row['wartosc']. "\n";
            fwrite($myfile, $txt);
        }
        fclose($myfile);

    $myfile = fopen("pomiary_przedwczoraj.txt", "w") or die("Unable to open file!");

        $txt = "   data    |  godzina  | wartość temperatury" . "\n";
        fwrite($myfile, $txt);
        while($row = mysqli_fetch_array($result_przedwczoraj))
        {
            $txt = $row['data']. " | " .$row['godzina']. "  | " .$row['wartosc']. "\n";
            fwrite($myfile, $txt);
        }
        fclose($myfile);
}
?>