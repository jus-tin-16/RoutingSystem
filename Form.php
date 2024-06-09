<?php
    //Database connection
    require_once 'connect_db.php';
?>

<?php
    if (isset($_POST['new_acc'])){
        $email = $_POST['email'];
        $userFirstName =  $_POST['userFirstName'];
        $userLastName = $_POST['userLastName'];
        $userMInitial= mysqli_real_escape_string($conn, $_POST['userMInitial']);
        $userName = mysqli_real_escape_string($conn, $_POST['userName']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (isset($_POST['genAccount'])){
            $sql = "SELECT * from useraccount where userName='$userName'";
            $result = $conn->query($sql);
            $count_user = mysqli_num_rows($result);

            $sql = "SELECT * from userinfo where userMail='$email'";
            $result = $conn->query($sql);
            $count_email = mysqli_num_rows($result);
                                    
            if ($count_user == 0 || $count_email == 0){
                $sql = "INSERT INTO useraccount(userName, userPass) VALUES(?,?)";
                $stmtinsert = $conn->prepare($sql);
                $result = $stmtinsert->execute([$userName, $password]);
                $user_id = mysqli_insert_id ($conn);
                if ($result){
                    echo "Success";
                }
                $sql = "INSERT INTO userinfo(userMail, FirstName, LastName, MiddleInitial, userId) VALUES(?,?,?,?,?)";
                $stmtinsert = $conn->prepare($sql);
                $result = $stmtinsert->execute([$email, $userFirstName, $userLastName, $userMInitial, $user_id]);
                if ($result){
                    echo "Success";
                }
            }
        }

        if (isset($_POST['adAccount'])){
            $conn = new mysqli("localhost", "root", "", "mydb");
            if (!$conn){
                die('Connection Failed : ' .mysql_error());
            }
            $sql = "SELECT * from managementaccount where adminName='$userName'";
            $result = $conn->query($sql);
            $count_user = mysqli_num_rows($result);

            $sql = "SELECT * from managerinfo where adminMail='$email'";
            $result = $conn->query($sql);
            $count_email = mysqli_num_rows($result);
                                    
            if ($count_user == 0 || $count_email == 0){
                $sql = "INSERT INTO managementaccount(adminName, adminPass) VALUES(?,?)";
                $stmtinsert = $conn->prepare($sql);
                $result = $stmtinsert->execute([$userName, $password]);
                $user_id = mysqli_insert_id ($conn);
                if ($result){
                    echo "Success";
                }
                $sql = "INSERT INTO managerinfo(adminMail, adminFName, adminLName, adminMInitial, adminId) VALUES(?,?,?,?,?)";
                $stmtinsert = $conn->prepare($sql);
                $result = $stmtinsert->execute([$email, $userFirstName, $userLastName, $userMInitial, $user_id]);
                if ($result){
                    echo "Success";
                }
            }
        }
    }

    if (isset($_POST['access'])){
        $userName = mysqli_real_escape_string($conn, $_POST['userName']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (isset($_POST['genAccount'])){
            $sql = $conn->prepare("SELECT * FROM useraccount WHERE userName = ?");
            $sql->bind_param("s", $userName);
            $sql->execute();
            $result = $sql->get_result();
            if ($result->num_rows > 0){
                $data = $result->fetch_assoc();
                if ($data['userPass'] === $password){
                        $_SESSION['id'] = $data['userId'];
                        header('Location: userDashboard.php');
                }
            }
        }

        if (isset($_POST['adAccount'])){
            $conn = new mysqli("localhost", "root", "", "mydb");
            if (!$conn){
                die('Connection Failed : ' .mysql_error());
            }
            $sql = $conn->prepare("SELECT * FROM managementaccount WHERE adminName = ?");
            $sql->bind_param("s", $userName);
            $sql->execute();
            $result = $sql->get_result();
            if ($result->num_rows > 0){
                $data = $result->fetch_assoc();
                if ($data['adminPass'] === $password){
                        $_SESSION['id'] = $data['adminId'];
                        header('Location: adminDashboard.php');
                }
            }
        }
    } 
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Routing System</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS Stylesheet of the Login -->
        <link rel="stylesheet" href="Form.css">
    </head>
    <body>
        <container>
        <div class="pane">

            <!-- Creating the Login -->
            <div class="form-container">
                <div class="select-container">
                    <div id="btn"></div>
                    <button type="button" class="toggle-btn" onclick="login()">Login</button>
                    <button type="button" class="toggle-btn" onclick="register()">Sign-Up</button>
                </div>
                <form action="Form.php" method="post">
                    <div id="login" class="input-group">
                        <div>
                            <input type="radio" name="user" id="user">
                            <label for="user">General User</label>
                            <input type="radio" name="user" id="admin">
                            <label for="admin">Admin</label>
                        </div>
                        <input id="username" type="userN" class="form-control" name="userName" placeholder="Username">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                        <label><input type="checkbox" value="">Remember me</label>
                        <button type="submit" class="btn-submit" name="access" value="Login">Submit</button>
                    </div>
                </form>

                <!-- Creating the Register -->
                <form action="Form.php" method="post">
                    <div id="register" class="input-group">
                        <div>
                            <input type="radio" name="user" id="user">
                            <label for="user">General User</label>
                            <input type="radio" name="user" id="admin">
                            <label for="admin">Admin</label>
                        </div>
                        <input id="email" type="email" class="form-control" name="email" placeholder="Email">
                        <input id="lname" type="lastName" class="form-control" name="userLastName" placeholder="Last Name">
                        <input id="fname" type="firstName" class="form-control" name="userFirstName" placeholder="First Name">
                        <input id="minitial" type="midInitial" class="form-control" name="userMInitial" placeholder="Middle initial">
                        <input id="username" type="userN" class="form-control" name="userName" placeholder="Username">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                        <label><input type="checkbox" value="">I agree to the Terms & Conditions</label>
                        <button type="submit" class="btn-submit" value="Signup" name="new_acc">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </container>

    <!-- Animation of the Button -->
    <script>
        var x = document.getElementById("login");
        var y = document.getElementById("register");
        var z = document.getElementById("btn");

        function register(){
            x.style.left = "-400px";
            y.style.left = "50px";
            z.style.left = "110px";
        }

        function login(){
            x.style.left = "50px";
            y.style.left = "450px";
            z.style.left = "0px";
        }
    </script>
    </body>
</html>