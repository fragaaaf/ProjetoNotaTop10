<?php
    session_start();
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $username = $_POST['username'];
        $password = $_POST['password']; 

        if($username && $password){
            include('./database/dbConnection.php');
            $query = "select username, id from tb_users where username='$username' and password = md5('$password')";
            $responseQuery = mysqli_query($connection, $query);
            $numRows = mysqli_num_rows($responseQuery);
            

            if($numRows == 1){
                $data = mysqli_fetch_row($responseQuery);
                $userId = $data[1];
                $query = "update tb_users set acessos = acessos + 1 where id={$userId}";
                $responseQuery = mysqli_query($connection, $query);
                $_SESSION['username'] = $username; 
                header('Location: index.php');
                exit;
            }else{
                $_SESSION['error_login'] = 'Falha de autenticação, tente novamente!';
                header('Location: login.php');
                exit;  

            }
        }else{
            $_SESSION['error_login'] = 'Todos os campos são obrigatórios';
            header('Location: login.php');
            exit;  

        }

    }


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
<body class="h-screen flex justify-center items-center bg-indigo-500">
    <form action="login.php" method="POST" autocomplete="off" class="bg-white w-96 rounded flex flex-col p-4">

        <h1 class="mb-4 text-3xl font-medium">Faça login</h1>
        <?php if(isset($_SESSION['error_login'])){ ?>
            <p class="p-2 rounded bg-red-300 my-4"><?php echo $_SESSION['error_login'];?></p>
        <?php unset($_SESSION['error_login']);}?>

        <?php if(isset($_SESSION['register_ok'])){ ?>
            <p class="p-2 rounded bg-indigo-300 my-4"><?php echo $_SESSION['register_ok'];?></p>
        <?php unset($_SESSION['register_ok']);}?>    

        <label for="username">Usuário</label>
        <input type="text" name="username" class="border border-gray-300 p-2 focus:outline-none text-indigo-500">
        <label for="">Senha</label>
        <input type="password" name="password" class="border border-gray-300 p-2 focus:outline-none text-indigo-500">

        <button class="p-2 border rounded mt-4 border-gray-300 text-indigo-500 hover:bg-indigo-500 hover:text-white focus:outline-none">ENTRAR</button>
        <p class="mt-4 text-sm text-right">Não tem uma conta? <a href="register.php" class="text-indigo-500 hover:underline">Clique aqui</a></p>
    </form>
</body>
</html>