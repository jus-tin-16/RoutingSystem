<?php
    require_once 'connect_db.php';
?>

<?php
    $conn = new mysqli("localhost", "root", "", "mydb");
    if (!$conn){
        die('Connection Failed : ' .mysql_error());
    }

    if(!empty($_SESSION['id'])){
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
        <link rel="stylesheet" href="userDashboard.css">
    </head>
    <body>
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
                    <a href="#" class="sidebar-link"><i class="lni lni-exit"></i><span>Logout</span></a>
                </div>
            </aside>
            <div class="main p-3">
                <div class="header">
                    <p>Management<p>
                    <h2>Report Surveillance</h2>
                </div>
                <div class="content-wrapper kanban">
                  <div class="row">
                    <div class="col-sm-6 mx-auto">
                        <div class="kanban-group" style="background-color: antiquewhite; margin: 15px; height: 480px; overflow: scroll;">
                            <div class="kanban-head" style="margin: 30px;">
                                <h5 id="title" style="font-size: 32px;">New Report</h5>
                            </div>
                            <div class="kanban-item" style="margin-left: 30px; margin-right: 30px; padding-bottom: 15px;">
                                <div class="vstack gap-2">
                                    <div class="card" aria-hidden="true">
                                        <div class="card-header" style="display: flex; align-content: center;">
                                            <h5 class="card-title">
                                                <span>Task 1</span>
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
                                        <p class="card-text placeholder-glow">
                                            <span class="placeholder col-7"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-6"></span>
                                            <span class="placeholder col-8"></span>
                                        </p>
                                        <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-6"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mx-auto">
                        <div class="kanban-group" style="background-color: antiquewhite; margin: 15px; height: 480px; overflow: scroll;">
                            <div class="kanban-head" style="margin: 30px;">
                                <h5 id="title" style="font-size: 32px;">In-Progress</h5>
                            </div>
                            <div class="kanban-item" style="margin-left: 30px; margin-right: 30px; padding-bottom: 15px;">
                                <div class="vstack gap-2">
                                    <div class="card" aria-hidden="true">
                                        <div class="card-body">
                                        <h5 class="card-title placeholder-glow">
                                            <span class="placeholder col-6"></span>
                                        </h5>
                                        <p class="card-text placeholder-glow">
                                            <span class="placeholder col-7"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-6"></span>
                                            <span class="placeholder col-8"></span>
                                        </p>
                                        <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-6"></a>
                                        </div>
                                    </div>
                                    <div class="card" aria-hidden="true">
                                        <div class="card-body">
                                        <h5 class="card-title placeholder-glow">
                                            <span class="placeholder col-6"></span>
                                        </h5>
                                        <p class="card-text placeholder-glow">
                                            <span class="placeholder col-7"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-6"></span>
                                            <span class="placeholder col-8"></span>
                                        </p>
                                        <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-6"></a>
                                        </div>
                                    </div>
                                    <div class="card" aria-hidden="true">
                                        <div class="card-body">
                                        <h5 class="card-title placeholder-glow">
                                            <span class="placeholder col-6"></span>
                                        </h5>
                                        <p class="card-text placeholder-glow">
                                            <span class="placeholder col-7"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-6"></span>
                                            <span class="placeholder col-8"></span>
                                        </p>
                                        <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-6"></a>
                                        </div>
                                    </div>
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
