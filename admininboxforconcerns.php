<!--------------------------- config here  ----------------------------->
<?php
require_once 'dbconfig.php';
include('./global/model.php');
$model = new Model();

if (isset($_REQUEST['del'])){
    $uid =intval($_GET['del']);
    $sql = "DELETE FROM tblusers WHERE id=:id";
    $query=$dbh->prepare($sql);

    $query->bindParam(':id', $uid, PDO::PARAM_STR);
    $query->execute();

    echo "<script>alert ('Post Successfully Deleted!');</script>";
    echo "<script>window.location.href='adminlandingpage.php'</script>";


}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> HOA+ Admin </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
   

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <!-- Custom fonts for this template-->
     <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

       <!-- Custom styles for this page -->
       <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


    <!-- <link href="style_postboard.css" rel="stylesheet"> -->
  </head>
  
<!--------------------------- left navigation  ----------------------------->

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                <i class="fa fa-home" aria-hidden="true"></i>
                </div>
                <div class="sidebar-brand-text mx-3">HOA+ Admin <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="adminlandingpage.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Manage Posts</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Members</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Manage Admins</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Payments</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Reservations</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_addamenities.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Add an Amenity </span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admininboxforconcerns.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Inbox </span></a>
            </li>
        
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <?php 
   require_once('session.php');
  //require_once('search.php');
  
  ?>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                   

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">President Aikka</span>
                                <img class="img-profile rounded-circle"
                                    src="photos/profile.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="admineditprofile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                             
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <!-- <div class="jumbotron">
             -->
            <!-- <div class="card">
                <div class="card-body">
          <div class="card-tools"> -->
                    <!-- Page Heading -->

                    <h1 class="h3 mb-4 text-gray-800">Admin Inbox</h1>
                    

                           <!---alert messages--->
              <?php 
                
                if(isset($_SESSION['message'])){
                    ?>
                    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert" style="margin-top:20px;">
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                 
                    
                        <?php echo $_SESSION['message']; ?>
                    </div>
                    <?php
 
                    unset($_SESSION['message']);
                }
            ?>

<div class="card">
  <div class="card-body">
    <!--Add buttons to initiate auth sequence and sign out-->
    <button id="authorize_button" onclick="handleAuthClick()" class="btn btn-success">Authorize</button>
    <button id="signout_button" onclick="handleSignoutClick()" class="btn btn-secondary">Sign Out</button>
    <button id="signout_button" id="view-compose-modal" onclick="viewmodal()" class="btn btn-primary" style="float: right;">Compose</button>

    <div class="container-fluid scroll" style="background-color: white;">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">From</th>
              <th scope="col">Messages</th>
              <th scope="col">Recieved</th>
            </tr>
          </thead>
          <tbody id="mail-body"> 

          </tbody>
        </table>

    </div>  


  </div>
</div>



<!--     <pre id="content" style="white-space: pre-wrap;"></pre> -->


<!-- Modal -->
<div class="modal fade" id="compose-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Compose Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <div class="mb-3">
        <input type="email" class="form-control" id="compose-to" placeholder="To" required />
      </div>
      <div class="mb-3">
        <input type="text" class="form-control" id="compose-subject" placeholder="Subject" required />
      </div>
      <div class="mb-3">
        <textarea class="form-control" placeholder="Message" id="compose-message" style="height: 100px" required></textarea>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="sendEmail()">Send Email</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="reply-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Reply Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <div class="mb-3">
        <p id="mes">sadsadsda</p>
      </div>
      <input type="text" class="form-control" id="reply-message-id" hidden="" />
      <br>
      <div class="mb-3">
        <input type="email" class="form-control" id="reply-to"  required />
      </div>
      <div class="mb-3">
        <input type="text" class="form-control" id="subject" required />
      </div>
      <div class="mb-3">
        <textarea class="form-control" placeholder="Message" id="reply-message" style="height: 100px"></textarea>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="replyEmail()">Send Reply</button>
      </div>
    </div>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">

      /* exported gapiLoaded */
      /* exported gisLoaded */
      /* exported handleAuthClick */
      /* exported handleSignoutClick */

      // TODO(developer): Set to client ID and API key from the Developer Console
      const CLIENT_ID = '444150896119-f6v2s9u383nrg3gsoeua2a7848nqh4u1.apps.googleusercontent.com';
      const API_KEY = 'AIzaSyANb76YrVjFHg3GMKZ6LSo_9AexKGvFqTg';

      // Discovery doc URL for APIs used by the quickstart
      const DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/gmail/v1/rest';

      // Authorization scopes required by the API; multiple scopes can be
      // included, separated by spaces.
      const SCOPES = 'https://www.googleapis.com/auth/gmail.readonly '+'https://www.googleapis.com/auth/gmail.send';

      let tokenClient;
      let gapiInited = false;
      let gisInited = false;

      document.getElementById('authorize_button').style.visibility = 'hidden';
      document.getElementById('signout_button').style.visibility = 'hidden';


      // document.getElementById("authorize_button").onclick(); 

      /**
       * Callback after api.js is loaded.
       */
      function gapiLoaded() {
        gapi.load('client', initializeGapiClient);
      }

      /**
       * Callback after the API client is loaded. Loads the
       * discovery doc to initialize the API.
       */
      async function initializeGapiClient() {
        await gapi.client.init({
          apiKey: API_KEY,
          discoveryDocs: [DISCOVERY_DOC],
        });
        gapiInited = true;
        maybeEnableButtons();
      }

      /**
       * Callback after Google Identity Services are loaded.
       */
      function gisLoaded() {
        tokenClient = google.accounts.oauth2.initTokenClient({
          client_id: CLIENT_ID,
          scope: SCOPES,
          callback: '', // defined later
        });
        gisInited = true;
        maybeEnableButtons();
      }

      /**
       * Enables user interaction after all libraries are loaded.
       */
      function maybeEnableButtons() {
        if (gapiInited && gisInited) {
          document.getElementById('authorize_button').style.visibility = 'visible';
        }
      }

      /**
       *  Sign in the user upon button click.
       */
      function handleAuthClick() {


      let timerInterval
      Swal.fire({
        html: 'Authenticate in <b></b> milliseconds.',
        timer: 4000,
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading()
          const b = Swal.getHtmlContainer().querySelector('b')
          timerInterval = setInterval(() => {
            b.textContent = Swal.getTimerLeft()
          }, 100)
        },
        willClose: () => {
          clearInterval(timerInterval)
        }
      }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
    
        tokenClient.callback = async (resp) => {
          if (resp.error !== undefined) {
            throw (resp);
          }
          document.getElementById('signout_button').style.visibility = 'visible';
          document.getElementById('authorize_button').innerText = 'Refresh';
          await listLabels();
        };

        if (gapi.client.getToken() === null) {
          // Prompt the user to select a Google Account and ask for consent to share their data
          // when establishing a new session.
          tokenClient.requestAccessToken({prompt: 'consent'});
        } else {
          // Skip display of account chooser and consent dialog for an existing session.
          tokenClient.requestAccessToken({prompt: ''});
        }

        }
      })

      }

      /**
       *  Sign out the user upon button click.
       */
      function handleSignoutClick() {
        const token = gapi.client.getToken();
        if (token !== null) {
          google.accounts.oauth2.revoke(token.access_token);
          gapi.client.setToken('');
          $("#mail-body").empty();
          document.getElementById('authorize_button').innerText = 'Authorize';
          document.getElementById('signout_button').style.visibility = 'hidden';
        }
      }

      /**
       * Print all Labels in the authorized user's inbox. If no labels
       * are found an appropriate message is printed.
       */
      async function listLabels() {
        let response;
        let messages;
        let list;
        let messages_lists = [];

        try {
          response = await gapi.client.gmail.users.labels.list({
            'userId': 'me',
          });

          //kukunin mo yung details ng lahat ng messages mo
          messages = await gapi.client.gmail.users.messages.list({
            'userId': 'me',
          });


        } catch (err) {
          document.getElementById('content').innerText = err.message;
          return;
        }

        $("#mail-body").empty();


        //mag for loop ka para makuha mo bawat id ng messages
        for (let i = 0; i < messages.result.messages.length; i++) {
         
         //dahil nakuha mo na ang bawat id, request ka nanaman ng data sa bawat message gamit yung id (messages.result.messages[i].id)
          list = await gapi.client.gmail.users.messages.get({
            'userId': 'me',
            'id': messages.result.messages[i].id
          });
          
        //gawa ka ng 2 variables na empty para paglagyan ng data later  
          let from = "";  
          let date = "";
          let subj = "";
          let replyid = "";  


            console.log(list.result.payload.headers);
        //for loop ka ulit para makuha yung From at Date
          for (let x = 0; x < list.result.payload.headers.length; x++) {


            if (list.result.payload.headers[x].name === "From") {

               //if yung array is equals Date add mo yung data sa from variable  
               from = list.result.payload.headers[x].value;
               
            }


            if (list.result.payload.headers[x].name === "Message-ID") {

               //if yung array is equals Date add mo yung data sa from variable  
               replyid = list.result.payload.headers[x].value;
               
            }

            if (list.result.payload.headers[x].name === "Subject") {

               //if yung array is equals Date add mo yung data sa from variable  
               subj = list.result.payload.headers[x].value;

            }

            
            if (list.result.payload.headers[x].name === "Date") {

              //if yung array is equals Date add mo yung data sa from variable   
               date_split = list.result.payload.headers[x].value.split(" "); 

              //convert date sa gusto mong format 
               date = date_split[2]+" "+date_split[1]+", "+date_split[3]; 

            }

          }


          //append mo yung html tags sa parent element para mag display, yang mail-body ay id ng isang element sa taas
          $("#mail-body").append(`
            <tr>
              <td>${from}</td>
              <td><a style="cursor: pointer; color: blue;" id="reply" data-mesid="${replyid}" data-from="${from}" data-subj="${subj}" data-message="${list.result.snippet}">${subj}</a></td>
              <td style="width: 200px;">${date}</td>
            </tr>

          `);

        }



      }



      $(document).on("click", "#reply", (e)=>{

        $("#reply-modal").modal("show");

        $("#reply-to").val(e.target.dataset.from);
        $("#subject").val(e.target.dataset.subj);
        $("#mes").text(e.target.dataset.message);
        $('#reply-message-id').val(e.target.dataset.mesid);

      });



      function sendMessage(headers_obj, message, callback)
      {
        //declare variable email na empty
        var email = '';
        
        //for loop para ma filter yung message
        for(var header in headers_obj)
          email += header += ": "+headers_obj[header]+"\r\n";
 
        email += "\r\n" + message;
        
        //dito na esesend ang message gamit gmail api
        var sendRequest = gapi.client.gmail.users.messages.send({
          'userId': 'me',
          'resource': {
            'raw': window.btoa(email).replace(/\+/g, '-').replace(/\//g, '_')
          }
        });
 
        return sendRequest.execute(callback);
      }

      function composeTidyReply()
      {
        $('#reply-modal').modal('hide');
 
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })
      //when message fields are blank, it should promt that message is not sent due to empty forms
        Toast.fire({
          icon: 'success',
          title: 'reply sent successfully'
        })

        $('#reply-to').val('');
        $('#subject').val('');
        $('#reply-message').val('');
 
      }

      function composeTidy()
      {
        $('#compose-modal').modal('hide');
 
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })

        Toast.fire({
          icon: 'success',
          title: 'sent successfully'
        })

        $('#compose-to').val('');
        $('#compose-subject').val('');
        $('#compose-message').val('');
 
      }

      function replyEmail()
      {
        
        //tawagin mo yung function na sendMessage() tapos lagay mo yung mga data na needed
        //kunin mo yung value ng element na may id compose-to at compose-subject
        // $("#reply-to").val(e.target.dataset.from);
        // $("#subject").val(e.target.dataset.subj);
        sendMessage(
          {
            'To': $('#reply-to').val(),
            'Subject': $('#subject').val(),
            'In-Reply-To': $('#reply-message-id').val()
          },
          $('#reply-message').val(),
          composeTidyReply
        );
 
        return false;
      }

      function sendEmail()
      {
        
        //tawagin mo yung function na sendMessage() tapos lagay mo yung mga data na needed
        //kunin mo yung value ng element na may id compose-to at compose-subject

        sendMessage(
          {
            'To': $('#compose-to').val(),
            'Subject': $('#compose-subject').val()
          },
          $('#compose-message').val(),
          composeTidy
        );
 
        return false;
      }

      function viewmodal() {

        $("#compose-modal").modal("show");
        
      }

      function getHeader(headers, index) {
        var header = '';
        $.each(headers, function(){
          if(this.name.toLowerCase() === index.toLowerCase()){
            header = this.value;
          }
        });
        return header;
      }


    </script>
 </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Capstone 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

     <!-- Bootstrap core JavaScript-->
     <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
    <script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
 
  <script src="jquery.min.js"></script>
 