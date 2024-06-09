<?php
    //connection to the database
    require_once 'connect_db.php';
?>

<?php
    //opening the report table
    $sql = "SELECT * FROM report";
    $all_report= $conn->query($sql);

    //opening report table
    $sql2 = "SELECT * FROM report";
    $all_report2 = $conn->query($sql);

    //get admin account details
    if(!empty($_SESSION['id'])){
        $conn = new mysqli("localhost", "root", "", "mydb");
        if (!$conn){
            die('Connection Failed : ' .mysql_error());
        }
        $id = $_SESSION['id'];
        $sql = $conn->prepare("SELECT * FROM managerinfo WHERE adminId = ?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $result = $sql->get_result();
        $data = $result->fetch_assoc();
        $_SESSION['user'] = $data['adminMail'];
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Routing System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Stylesheet connection -->
        <link rel="stylesheet" href="userDashboard.css">
    </head>
    <body>
        <!-- Sidebar -->
        <div class="wrapper">
            <aside id="sidebar">
                <div class="d-flex">
                    <button class="toggle-button" type="button"><i class="lni lni-grid-alt"></i></button>
                    <div class="sidebar-logo">
                        <a href="#">Routing System</a>
                    </div>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link"><i class="lni lni-user"></i><span>
                        <?php echo $_SESSION['user']; ?>
                        </span></a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link"><i class="lni lni-display"></i><span>Dashboard</span></a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link"><i class="lni lni-alarm"></i><span>Notification</span></a>
                    </li>
                </ul>
                <div class="sidebar-footer">
                    <a href="logout.php" class="sidebar-link"><i class="lni lni-exit"></i><span>Logout</span></a>
                </div>
            </aside>

            <!-- Body -->
            <div class="main p-3" action="userDashboard.php" method="POST">
                <div class="header">
                    <p>Management<p>
                    <h2>Report Surveillance</h2>
                </div>
                <!-- Creating the Kanban -->
                <div class="content-wrapper kanban">
                  <div class="row">
                    <div class="col-sm-6 mx-auto">
                        <div class="kanban-group" style="background-color: antiquewhite; margin: 15px; height: 480px; overflow: scroll;">
                            <div class="kanban-head" style="margin: 30px;">
                                <h5 id="title" style="font-size: 32px;">New Report</h5>
                            </div>
                            <div class="kanban-item" style="margin-left: 30px; margin-right: 30px; padding-bottom: 15px;">

                                <!-- Creating the Card Stack -->
                                <div class="vstack gap-2">
                                    <?php
                                            //Displaying reports with the status of 'new'
                                             if ($all_report->num_rows > 0) {
                                                while ($row = $all_report->fetch_assoc()) {
                                                    $conn = new mysqli("localhost", "root", "", "mydb");
                                                    $sql = $conn->prepare("SELECT * from tasks WHERE taskNo = ?");
                                                    $sql->bind_param("i", $row['reportFormNo']);
                                                    $sql->execute();
                                                    $result = $sql->get_result();
                                                    $task = $result->fetch_assoc();
                                                    $stat = $task['status'];
                                                    if ($stat === 'new'){
                                    ?>
                                    <div class="card" aria-hidden="true" >
                                        <div class="card-header" style="display: flex; align-content: center;">
                                            <h5 class="card-title">
                                                <span><?php echo $row['repSubject']; ?></span>
                                            </h5>
                                            <div class="card-tools">
                                                <button class="btn" style="background-color: transparent; border: none;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">
                                                    <i class="lni lni-frame-expand"></i>
                                                </button>
                                                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel">
                                                    <div class="offcanvas-header">
                                                      <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Offcanvas with backdrop</h5>
                                                      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                    </div>
                                                    <div class="offcanvas-body">
                                                      <p>.....</p>
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <?php 
                                                        echo $row['content'];
                                                ?>
                                            </p>
                                            <div class="btn-group">
                                                <!-- Updating the status of the report - directs to update_stat.php -->
                                                <form action="update_stat.php" method="post">
                                                    <?php echo "<input type=hidden name=id value='".$row['reportFormNo']."'>" ?>
                                                    <button class="btn btn-primary" name="complete" value="completed">Mark as complete</button>
                                                    <button class="btn btn-secondary" name="progress" value="inprogress">In-progress-></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--  In-Progress Kanban -->
                    <div class="col-sm-6 mx-auto">
                        <div class="kanban-group" style="background-color: antiquewhite; margin: 15px; height: 480px; overflow: scroll;">
                            <div class="kanban-head" style="margin: 30px;">
                                <h5 id="title" style="font-size: 32px;">In-Progress</h5>
                            </div>
                            <div class="kanban-item" style="margin-left: 30px; margin-right: 30px; padding-bottom: 15px;">
                                <!-- Creating the Card Stack -->
                                <div class="vstack gap-2">
                                    <?php   
                                            //Displaying report with the status of 'inprogress'
                                            if ($all_report2 ->num_rows > 0) {
                                                while ($row = $all_report2->fetch_assoc()) {
                                                    $conn = new mysqli("localhost", "root", "", "mydb");
                                                    $sql = $conn->prepare("SELECT * from tasks WHERE taskNo = ?");
                                                    $sql->bind_param("i", $row['reportFormNo']);
                                                    $sql->execute();
                                                    $result = $sql->get_result();
                                                    $task = $result->fetch_assoc();
                                                    $stat = $task['status'];
                                                    if ($stat === 'inprogress'){
                                    ?>
                                    <div class="card" aria-hidden="true">
                                        <div class="card-header" style="display: flex; align-content: center;">
                                            <h5 class="card-title">
                                                <span><?php echo $row['repSubject']; ?></span>
                                            </h5>
                                            <div class="card-tools">
                                                <button class="btn" style="background-color: transparet; border: none;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">
                                                    <i class="lni lni-frame-expand"></i>
                                                </button>
                                                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel">
                                                    <div class="offcanvas-header">
                                                      <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Offcanvas with backdrop</h5>
                                                      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                    </div>
                                                    <div class="offcanvas-body">
                                                      <p>.....</p>
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text">
                                            <?php echo $row['content']; ?>
                                            </p>
                                            <div class="btn-group">
                                                <!-- Updating the status of the report - directs to update_stat.php -->
                                                <form action="update_stat.php" method="post">
                                                    <?php echo "<input type=hidden name=id value='".$row['reportFormNo']."'>" ?>
                                                    <button class="btn btn-primary" name="complete" value="completed">Mark as complete</button>
                                                    <button class="btn btn-secondary disabled" name="progress" value="inprogress">In-progress-></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                                }
                                           }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script>
         const hamburger = document.querySelector(".toggle-button");
            
            hamburger.addEventListener("click",function () {
                document.querySelector("#sidebar").classList.toggle("expand");
            });
         </script>
    </body>
</html>
