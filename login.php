<?php 
session_start(); 
include "connect.php";
if (isset($_POST['email']) && isset($_POST['pswd'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['email']);
	$pass = validate($_POST['pswd']);

	if (empty($uname)) {
		header("Location: Connexion.php?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: Connexion.php?error=Password is required");
	    exit();
	}else{
        $host = 'localhost'; // Remplacez par votre hôte de base de données
        $user = 'root'; // Remplacez par votre nom d'utilisateur de base de données
        $password = ''; // Remplacez par votre mot de passe de base de données
        $database = 'projet'; // Remplacez par le nom de votre base de données

// Connexion à la base de données
$conn = mysqli_connect($host, $user, $password, $database);
		$sql = "SELECT * FROM utilisateurs WHERE email='$uname' and password='$pass'";
        
		$result = mysqli_query($conn, $sql);
        if ($result === false) {
            echo "Erreur de requête : " . mysqli_error($conn);
        } else {
            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                if ($row['Email'] == $uname && $row['password'] == $pass) {
                    $_SESSION['email'] = $row['Email'];
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['pswd'] = $row['password'];
                    header("Location: home.php");
                    exit();
                
                }
            }else{
                header("Location: Connexion.php?error=Incorect User name or password");
                exit();
            }
	}
}
}else{
	header("Location: Connexion.php");
	exit();
}