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

    $temperatura_odebrana = $_POST['temperatura'];
    $temperatura = (double)$temperatura_odebrana;

    date_default_timezone_set('Europe/Warsaw');
    $data = date("Y-m-d");
    $godzina = date("H:i:s");
    mysqli_query($connection,"INSERT INTO pomiary (wartosc, data, godzina) VALUES ('$temperatura','$data','$godzina')");

    mysqli_close($connection);
    ?>

