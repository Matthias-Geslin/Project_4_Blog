<?php
namespace App\Controller;

use App\Model\Factory\ModelFactory;
use App\Model\Factory\PDOFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class UsersController
 * @package App\Controller
 */
class UsersController extends MainController
{
    /**
     * @return string
     */
    public function launchMethod()
    {

        $servername = 'localhost';      // Change it to your servername
        $username = 'root';             // Change it to your database username
        $pass = 'root';                 // Change it to your database password
        $db = 'p4blog';    // Change it to your database name

        $conn = mysqli_connect($servername, $username, $pass,$db);
        if(isset($_POST['login_btn'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $encPassword = md5($password);
            $checkUsers = ModelFactory::getModel('users')->getUser($email);
            $query = "SELECT * FROM `users` WHERE email = '$email'";
            $runQuery = mysqli_query($conn, $query);
            $countResults = mysqli_num_rows($runQuery);
            if($countResults == 0){
                echo "User Email doesn't Exist.";
            }
            else{
                $row = mysqli_fetch_array($runQuery);
                $dbId = $row['id'];
                $dbFirstName = $row['first_name'];
                $dbLastName = $row['last_name'];
                $dbEmail = $row['email'];
                $dbPassword = $row['password'];
                $dbRole = $row['role'];
                $dbStatus = $row['status'];

                if($encPassword == $dbPassword && $dbStatus == 1){
                    if($dbRole == 1){
                        $_SESSION["logged_in"] = 1;
                        $_SESSION['id'] = $dbId;
                        $_SESSION['first_name'] = $dbFirstName;
                        $_SESSION['last_name'] = $dbLastName;
                        $_SESSION['email'] = $dbEmail;
                        $_SESSION['role'] = $dbRole;
                        $_SESSION['status'] = $dbStatus;

                        $this->redirect('users');
                    }
                    elseif($dbRole == 2){
                        $_SESSION["logged_in"] = 1;
                        $_SESSION['id'] = $dbId;
                        $_SESSION['first_name'] = $dbFirstName;
                        $_SESSION['last_name'] = $dbLastName;
                        $_SESSION['email'] = $dbEmail;
                        $_SESSION['role'] = $dbRole;
                        $_SESSION['status'] = $dbStatus;
                        return $this->redirect("connexion");

                    }
                }
                else{
                    echo "Invalid Password or Inactive User";
                }
            }
        }

    }
}