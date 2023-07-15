<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        name<input type="text" name="Nom">
        adr <input type="text" name="adresse" id="">
        numero <input type="text" name="num">
        <input type="submit" name="ok">
    </form>
    <?php
    if (isset($_POST["ok"])) {


        $pdo = new PDO("mysql:host=localhost;dbname=phptest", "root", "");
        $request = $pdo->prepare("insert into idtable1(nom, adr, numero)values(?,?,?)");
        $nom = $_POST["Nom"];
        $adr = $_POST["adresse"];
        $num = $_POST["num"];

        $request->execute(array($nom, $adr, $num));

        $request1 = $pdo->prepare("select * from idtable1 order by id");
        $request1->setFetchMode(PDO::FETCH_ASSOC);
        $request1->execute();
        $table = $request1->fetchAll();
        foreach ($table as $line) {
            foreach ($line as $values) {
                echo $values . '<br>';
            }
        }

    }










    ?>

</body>

</html>