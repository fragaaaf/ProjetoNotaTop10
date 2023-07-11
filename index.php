<?php
    session_start();

    if(!isset($_SESSION['username'])){
        header('location: login.php');
        exit;
    }
    //chegou aqui ele está autenticado
    include('./database/dbConnection.php');
    
    $username = $_SESSION['username'];

    $query = "select username, acessos from tb_users order by acessos desc limit 10";
    $responseQuery = mysqli_query($connection, $query);
    $data = mysqli_fetch_all($responseQuery); 

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="h-screen flex flex-col justify-center items-center bg-green-500 text-white">
    <p class="text-3xl mb-6">Seja bem vindo, <?php echo $username; ?></span></p>

    <div action="register.php" method="POST" autocomplete="off" class="bg-white w-96 rounded flex flex-col p-4 text-black">
        <h1 class="text-2xl mb-4 border-b pb-3">Top 10</h1>
        <?php for($i=0; $i<count($data); $i++){ ?>
            <?php if($data[$i][0] == $username){ ?>
                <p class="flex justify-between text-green-500"><span class=""><?php echo $i+1; ?>. <?php echo $data[$i][0];?></span><?php echo $data[$i][1];?></p>
            <?php }else{ ?>
                <p class="flex justify-between"><span class=""><?php echo $i+1; ?>. <?php echo $data[$i][0];?></span><?php echo $data[$i][1];?></p>
            <?php } ?>    
        <?php } ?>
    </div>

    <p class="mt-4"><a href="logout.php">Sair</a></p>
</body>
</html>