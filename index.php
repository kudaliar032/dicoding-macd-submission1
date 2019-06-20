<?php
include "environment.php";

try {
    $conn = new PDO("sqlsrv:server = tcp:".$_ENV['HOST'].",1433; Database = ".$_ENV['DB'], $_ENV['UNAME'], $_ENV['PASS']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

try {
    $sqlSelectAllData = "SELECT * FROM guest_book";
    $exe1 = $conn->query($sqlSelectAllData);
    $guest_list = $exe1->fetchAll();
} catch (Exception $e) {
    echo "Gagal".$e;
}

if (isset($_POST['submit'])) {
    try {
        $id = time();
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // Insert data
        $sql_insert = "INSERT INTO guest_book (id, name, email, phone) 
                        VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bindValue(1, $id);
        $stmt->bindValue(2, $name);
        $stmt->bindValue(3, $email);
        $stmt->bindValue(4, $phone);
        $stmt->execute();

        unset($_POST);
        header("Refresh:0");
    } catch(Exception $e) {
        echo "Gagal".$e;
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GUEST BOOK</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-dark bg-danger">
    <a class="navbar-brand" href="#">Guest Book</a>
</nav>
<div class="row">
    <div class="col-md-6">
        <form class="m-4" method="post">
            <div class="form-group">
                <label for="nameinput"><b>Nama</b></label>
                <input name="name" type="text" class="form-control" id="nameinput" placeholder="Masukan nama" required>
            </div>
            <div class="form-group">
                <label for="emailinput"><b>Email</b></label>
                <input name="email" type="email" class="form-control" id="emailinput" placeholder="Masukan email" required>
            </div>
            <div class="form-group">
                <label for="phoneinput"><b>Ponsel</b></label>
                <input name="phone" type="number" class="form-control" id="phoneinput" placeholder="Masukan nomor ponsel" required>
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Kirim</button>
        </form>
    </div>

    <div class="col-md-6">
        <div class="m-4">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nomor ponsel</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($guest_list as $key => $item): ?>
                        <tr>
                            <th scope="row"><?php echo $key+1 ?></th>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['email']; ?></td>
                            <td><?php echo $item['phone']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>