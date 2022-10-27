<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> HOA+ Admin </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    
    <link href="style.css" rel="stylesheet">
 
    <style type="text/css">
    .scroll {
    max-height: 700px;
    overflow-y: auto;
    }      
    </style>

  </head>
  <body>
    <!--------------------------- left navigation  ----------------------------->
      <div class="left">
        <div class="left-panel">
          <div class="left-panel-content">
          <img class="admin-profile" src="photos/user.png"></img>
          <a href="#" class="nav-profile"> Hi Admin! </a>
        
            <div class="nav-panel">

              <a href="admin_postboard.php">  Post Board </a>
              <a href="manageposts.php"> Manage Posts </a>
              <a class= > Members </a>
              <a class= > Payment </a>
              <a href="inbox.php"> Inbox </a>
                          
            </div>
          </div>
          <a class="logout" href="logout.php" > Logout</a>
        </div>
      </div>

    <!--------------------------- Right Panel Contents ----------------------------->
    <div class="right"> 
      <div class="right-content">
          <div class="title">
            <a href="index.php"><img src="photos/Logo 2.png" class="logo"> </a>
            <h2> Homeowners Association </h2>
          </div>


        <div class="heading">
              <div class="heading-content">
                <img src="photos/member.png"><h2 class="card-title"> INBOX </h2>
              </div>
        </div>
    
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
              <th scope="col">Received</th>
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
        <textarea class="form-control" placeholder="Message" id="compose-message" style="height: 100px"></textarea>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="sendEmail()">Send Email</button>
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
          messages = await gapi.client.gmail.users.messages.list({
            'userId': 'me',
          });


        } catch (err) {
          document.getElementById('content').innerText = err.message;
          return;
        }

        // console.log(messages.result.messages[0].id);
        $("#mail-body").empty();
        for (let i = 0; i < messages.result.messages.length; i++) {
         
          list = await gapi.client.gmail.users.messages.get({
            'userId': 'me',
            'id': messages.result.messages[i].id
          });
          
          let from = "";  
          let date = "";
 
          for (let x = 0; x < list.result.payload.headers.length; x++) {
            
            if (list.result.payload.headers[x].name === "From") {

               from = list.result.payload.headers[x].value;

            }
            
            if (list.result.payload.headers[x].name === "Date") {

               date_split = list.result.payload.headers[x].value.split(" "); 

               date = date_split[2]+" "+date_split[1]+", "+date_split[3]; 

            }

          }

          $("#mail-body").append(`
            <tr>
              <td>${from}</td>
              <td>${list.result.snippet}</td>
              <td>${date}</td>
            </tr>

          `);

        }

        let sample = 'Mon, 03 Oct 2022 07:30:31 +0000';
        console.log(sample.split(" "));

        const labels = response.result.labels;
        if (!labels || labels.length == 0) {
          document.getElementById('content').innerText = 'No labels found.';
          return;
        }
        // // Flatten to string to display
        // const output = labels.reduce(
        //     (str, label) => `${str}${label.name}\n`,
        //     'Labels:\n');
        // document.getElementById('content').innerText = output;
      }

 
        // sendMessage(
        //   {
        //     'To': $('#compose-to').val(),
        //     'Subject': $('#compose-subject').val()
        //   },
        //   $('#compose-message').val(),
        //   composeTidy
        // );


      function sendMessage(headers_obj, message, callback)
      {
        var email = '';
 
        for(var header in headers_obj)
          email += header += ": "+headers_obj[header]+"\r\n";
 
        email += "\r\n" + message;
 
        var sendRequest = gapi.client.gmail.users.messages.send({
          'userId': 'me',
          'resource': {
            'raw': window.btoa(email).replace(/\+/g, '-').replace(/\//g, '_')
          }
        });
 
        return sendRequest.execute(callback);
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

      function sendEmail()
      {
 
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




    </script>

    <script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
    <script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
 
  <script src="jquery.min.js"></script>
 
  </body>
</html>