<?php
    session_start();

    if($_SERVER['REQUEST_METHOD']==='POST'){
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

            if($username && $password && $password2){
                
                if($password === $password2){
                    include('./database/dbConnection.php');
                    $query = "SELECT username FROM tb_users where username='$username'";
                    $responseQuery = mysqli_query($connection, $query);
                    $numRows = mysqli_num_rows($responseQuery);
                   
                    
                    if($numRows == 1 ){
                        $_SESSION['error_register'] = 'Este usuário já está cadastrado!';
                        header('Location: register.php');
                        exit;    
                    }
                    
                    $query = "INSERT INTO tb_users(username, password) values('$username', md5('$password'))";
                    $responseQuery = mysqli_query($connection, $query);
                    //$numRows = mysqli_num_rows($responseQuery);

                    if($responseQuery == 1){
                        $_SESSION['register_ok'] = 'Conta criada com sucesso. Faça login!';
                        header('Location: login.php');
                        exit;   
                    }else{
                        $_SESSION['error_register'] = "Erro na criação do usuario!";
                        header('Location: register.php');
                        exit;    
                    }

                }else{
                    $_SESSION['error_register'] = 'As senhas não coincidem!';
                    header('Location: register.php');
                    exit;
                }
            }else{
                $_SESSION['error_register'] = 'Todos os campos são obrigatórios';
                header('Location: register.php');
                exit;
            }


    }else{

        echo "Error";
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
<body class="h-screen flex justify-center items-center bg-green-500">
    <form action="register.php" method="POST" autocomplete="off" class="bg-white w-96 rounded flex flex-col p-4">

        <h1 class="mb-4 text-3xl font-medium">Crie uma conta</h1>
            <?php if(isset($_SESSION['error_register'])){ ?>
                <p class="p-2 rounded bg-red-300 my-4"><?php echo $_SESSION['error_register'];?></p>
            <?php unset($_SESSION['error_register']);}?>
        <label for="username">Usuário</label>
        <input type="text" name="username" class="border border-gray-300 p-2 focus:outline-none text-green-500">

        <label for="password">Senha</label>
        <input type="password" name="password" class="border border-gray-300 p-2 focus:outline-none text-green-500">

        <label for="password">Senha novamente</label>
        <input type="password" name="password2" class="border border-gray-300 p-2 focus:outline-none text-green-500">

        <button class="p-2 border rounded mt-4 text-green-500 border-gray-300 hover:bg-green-500  hover:text-white focus:outline-none">REGISTRAR</button>
        <p class="mt-4 text-sm text-right">Já é registrado? <a href="login.php" class="text-green-500 hover:underline">faça login</a></p>
    </form>
</body>
</html>