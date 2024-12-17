<!doctype html>
<html lang="en">
  <head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../login/css/style.css">
  </head>
  <body>
    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 text-center mb-5">
            <h2 class="heading-section">Exam Super Apps</h2>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-12 col-lg-10">
            <div class="wrap d-md-flex">
              <div class="img" style="background-image: url(../login/images/bg-1.jpg);"></div>
              <div class="login-wrap p-4 p-md-5">
                <div class="d-flex">
                  <div class="w-100">
                    <h3 class="mb-4">Sign In</h3>
                  </div>
                </div>
                <form action="#" class="signin-form" id="dataForm">
                  <div class="form-group mb-3">
                    <label class="label" for="name">Username</label>
                    <input type="text" id="username" class="form-control" placeholder="Username" required>
                  </div>
                  <div class="form-group mb-3">
                    <label class="label" for="password">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Password" required>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Toast Notification -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
      <div id="toastError" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="d-flex">
          <div id="toastMessage" class="toast-body text-white">
            Gagal login! Silakan cek kembali username dan password.
          </div>
        </div>
      </div>
    </div>

    <script src="../login/js/jquery.min.js"></script>
    <script src="../login/js/popper.js"></script>
    <script src="../login/js/bootstrap.min.js"></script>
    <script src="../login/js/main.js"></script>

    <script>
      $(document).ready(function() {
        // Inisialisasi Toast
        const toastElement = document.getElementById('toastError');
        const toast = new bootstrap.Toast(toastElement);
        const toastMessage = document.getElementById('toastMessage');

        $("#dataForm").on("submit", function(e) {
          e.preventDefault();
          const username = $("#username").val();
          const password = $("#password").val();

          $.ajax({
            url: '{{ config('app.url') }}' + "/login",
            type: "POST",
            contentType: "application/x-www-form-urlencoded",
            data: {
              username: username,
              password: password
            },
            success: function(response) {
              console.log('Response dari server:', response);
              if (response.success) {
                  const data = response.data[0];
                  console.log(data);
                  
                  window.location.href = `/create-session/${username}/${data.id}/${data.token_app}`;
              } else {
                  toastMessage.textContent = "Gagal login! Silakan cek kembali username dan password.";
                  toastElement.classList.remove('text-bg-primary');
                  toastElement.classList.add('bg-danger');
                  toast.show();
              }
            },
            error: function(xhr, status, error) {
              toastMessage.textContent =  xhr.responseJSON.message;
              toastElement.classList.remove('text-bg-primary');
              toastElement.classList.add('bg-danger');
              toast.show();
            }
          });
        });
      });
    </script>
  </body>
</html>
