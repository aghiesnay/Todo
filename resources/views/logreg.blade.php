@extends('layout')
@section('content')

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in & Sign up</title>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  </head>
  <body>

    @if (session('successAdd'))
      <script>
        Swal.fire(
        'Berhasil menambahkan akun!',
        'Silahkan login',
        'success',)
      </script>
    @endif

    @if(session('notAllowed'))
    <script>
      Swal.fire(
      'Gagal login!',
      'Silahkan check dan coba lagi',
      'error',)
    </script>
    @endif

    <main>
      <div class="box">
        <div class="inner-box">
          <div class="forms-wrap">
            <form method="POST" action="{{route('login.auth')}}" autocomplete="off" class="sign-in-form">
              @csrf
              <div class="logo">
                <img src="assets/img/logo-todo.png" alt="easyclass" />
                <h4>Todo App</h4>
              </div>

              <div class="heading">
                <h2>Welcome Back</h2>
                <h6>Not registred yet?</h6>
                <a href="#" class="toggle">Sign up</a>
              </div>

              <div class="actual-form">
                <div class="input-wrap">
                  <input
                    type="text"
                    name="username"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Username</label>
                </div>

                <div class="input-wrap">
                  <input
                    type="password"
                    name="password"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Password</label>
                </div>

                <input type="submit" value="Sign In" class="sign-btn" />

                <!-- <p class="text">
                  Forgotten your password or you login datails?
                  <a href="#">Get help</a> signing in
                </p> -->
              </div>
            </form>

            <form method="POST" action="{{route('logreg.input')}}" autocomplete="off" class="sign-up-form">
              @csrf
              <div class="logo">
                <img src="assets/img/logo-todo.png" alt="easyclass" />
                <h4>Todo App</h4>
              </div>

              <div class="heading">
                <h2>Get Started</h2>
                <h6>Already have an account?</h6>
                <a href="#" class="toggle">Sign in</a>
              </div>

              <div class="actual-form">
                <div class="input-wrap">
                  <input
                    type="text"
                    name="name"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Name</label>
                </div>

                <div class="input-wrap">
                  <input
                    type="text"
                    name="username"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Username</label>
                </div>

                <div class="input-wrap">
                  <input
                    type="email"
                    name="email"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Email</label>
                </div>

                <div class="input-wrap">
                  <input
                    type="password"
                    name="password"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Password</label>
                </div>

                <input type="submit" value="Sign Up" class="sign-btn" />
               <!-- 
                <p class="text">
                  By signing up, I agree to the
                  <a href="#">Terms of Services</a> and
                  <a href="#">Privacy Policy</a>
                </p> -->
              </div>
            </form>
          </div>

          <div class="carousel">
            <div class="images-wrapper">
              <img src="assets/img/img.jpeg" class="image img-1 show" alt="" />
              <!-- <img src="./img/image2.png" class="image img-2" alt="" />
              <img src="./img/image3.png" class="image img-3" alt="" /> -->
            </div>

            <div class="text-slider">
              <div class="text-wrap">
                <div class="text-group">
                  <h2>Create your own list</h2>
                  <!-- <h2>Customize as you like</h2>
                  <h2>Invite students to your class</h2> -->
                </div>
              </div>

              <!-- <div class="bullets">
                <span class="active" data-value="1"></span>
                <span data-value="2"></span>
                <span data-value="3"></span>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Javascript file -->

    <script src="assets/js/app.js"></script>
    @endsection
  </body>
</html>
