<?php
    //connection to database
    require_once 'connect_db.php'
?>

<?php
    //accessing the user details
    if(!empty($_SESSION['id'])){
        $id = $_SESSION['id'];
        $sql = $conn->prepare("SELECT * FROM userinfo WHERE userId = ?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $result = $sql->get_result();
        $data = $result->fetch_assoc();
        $_SESSION['user'] = $data['userMail'];
    }   

    //submit report code block
    if (isset($_POST['submit-report'])){
        $reportTitle = $_POST['reportTitle'];
        $reportContext =  $_POST['reportContext'];
        $reportDate = $_POST['reportDate'];
        $Status = $_POST['submit-report'];

        // Handle file upload for document
        $reportFile = null;
        if (isset($_FILES['reportFile']) && $_FILES['reportFile']['error'] == UPLOAD_ERR_OK) {
            $reportFile = file_get_contents($_FILES['reportFile']['tmp_name']);
        }

        // Handle file upload for image
        $reportImage = null;
        if (isset($_FILES['reportImage']) && $_FILES['reportImage']['error'] == UPLOAD_ERR_OK) {
            $reportImage = file_get_contents($_FILES['reportImage']['tmp_name']);
        }

        $sql = "INSERT INTO report(repSubject, content, date, attach, images) VALUES(?, ?, ?, ?, ?)";
        $stmtinsert = $conn->prepare($sql);
        $stmtinsert->bind_param("sssss", $reportTitle, $reportContext, $reportDate, $reportFile, $reportImage);
        $result = $stmtinsert->execute();
        $report = mysqli_insert_id ($conn);

        if ($result === TRUE){
            echo "Success";
            $conn = new mysqli("localhost", "root", "", "mydb");
            if (!$conn){
                die('Connection Failed : ' .mysql_error());
            }
            $sql = "INSERT INTO tasks(status, reportNo) VALUES(?, ?)";
            $stmtinsert = $conn->prepare($sql);
            $stmtinsert->bind_param("si", $Status, $report);
            $result = $stmtinsert->execute();
            $_SESSION['taskId'] = $report;
            if ($result === TRUE){
                echo "Success";
            }
        } else {
             echo "Error: " . $sql . "<br>" . $conn->error;
        }
            
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
        <!-- stylesheet connection -->
        <link rel="stylesheet" href="userDashboard.css">
    </head>
    <body>
        <!-- this is the code for sidebar -->
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
                        <a href="userDashboard.php" class="sidebar-link"><i class="lni lni-write"></i><span>Send Report</span></a>
                    </li>
                </ul>
                <div class="sidebar-footer">
                    <a href="logout.php" class="sidebar-link"><i class="lni lni-exit"></i><span>Logout</span></a>
                </div>
            </aside>

            <!-- Main or the body -->
            <div class="main p-3">
                <div class="header">
                    <p>Order Work Form<p>
                    <h2>Maintenance Report</h2>
                </div>

                <!-- The report Form -->
                <div class="form-container">
                    <h4>New Report</h4>
                    <form action="userDashboard.php" method="POST" enctype="multipart/form-data">
                        <div id="report-form">
                            <!-- Subject Title text box -->
                            <div class="input-group">
                                <span><label for="report-subject" class="form-label">Subject: </label></span>
                                <input type="title" class="form-control" id="report-subject" name="reportTitle" placeholder="Subject">
                            </div>
                            <!-- Content of the report text area -->
                            <div class="mb-3">
                                <span><label for="report-body" class="form-label">Compose report: </label></span>
                                <textarea class="form-control" id="report-body" rows="5" name="reportContext" placeholder="Message"></textarea>
                            </div>
                            <!-- Hidden Date input field -->
                            <div class="mb-3" id="date-input-container" style="display: none;">
                                <span><label for="report-date" class="form-label">Date: </label></span>
                                <input type="date" class="form-control" id="report-date" name="reportDate">
                            </div>
                            <!-- Hidden File input field for documents -->
                            <div class="mb-3" id="file-input-container" style="display: none;">
                                <span><label for="report-file" class="form-label">Attach Document: </label></span>
                                <input type="file" class="form-control" id="report-file" name="reportFile">
                            </div>
                            <!-- Hidden File input field for images -->
                            <div class="mb-3" id="image-input-container" style="display: none;">
                                <span><label for="report-image" class="form-label">Attach Image: </label></span>
                                <input type="file" class="form-control" id="report-image" name="reportImage">
                            </div>
                            <div class="row">
                                <!-- Submit Button -->
                                <div class="col-sm-8">
                                    <button type="submit" class="btn-submit" name="submit-report" value="new">Submit</button>
                                </div>
                                <div class="col-sm-1">
                                    <!-- Attach Document Button -->
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Attach Document" data-bs-placement="bottom">
                                        <button type="button" class="btn-tool" name="attach-doc" onclick="showFileInput()"><i class="lni lni-paperclip"></i></button>
                                    </span>
                                </div>
                                <div class="col-sm-1">
                                    <!-- Attach Image Button -->
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Attach Image" data-bs-placement="bottom">
                                        <button type="button" class="btn-tool" name="attach-img" onclick="showImageInput()"><i class="lni lni-image"></i></button>
                                    </span>
                                </div>
                                <div class="col-sm-1">
                                    <!-- Set Date Button -->
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Set Date & Time" data-bs-placement="bottom">
                                        <button type="button" class="btn-tool" name="calendar" onclick="showDateInput()"><i class="lni lni-calendar"></i></button>
                                    </span>
                                </div>
                                <div class="col-sm-1">
                                    <!-- Attach Signature Button -->
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Attach Signature" data-bs-placement="bottom">
                                        <button type="button" class="btn-tool" name="sign"><i class="lni lni-pencil"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Add hidden file inputs -->
        <input type="file" id="attach-doc-input" style="display: none;">
        <input type="file" id="attach-img-input" style="display: none;">
        
        <!-- Script for sidebar animation -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script>
         const hamburger = document.querySelector(".toggle-button");
            
            hamburger.addEventListener("click",function () {
                document.querySelector("#sidebar").classList.toggle("expand");
            });

            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

            function showDateInput() {
                document.getElementById('date-input-container').style.display = 'block';
            }

            function showFileInput() {
                document.getElementById('file-input-container').style.display = 'block';
            }

            function showImageInput() {
                document.getElementById('image-input-container').style.display = 'block';
            }
         </script>
    </body>
</html>