<!DOCTYPE html>
<html lang="en">
<link>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="generator" content="Hugo 0.104.2">
<title>Signin</title>
<link href="{{asset('assets/img/favicon.ico')}}">
<link href="{{asset('assets/img/favicon.ico')}}">

<link href="{{ asset('assets1/css/bootstrap.min.css')}}" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="{{ asset('assets1/css/style.css') }}" rel="stylesheet">
<!-- Boxicons CSS -->
<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
<style>
  .bx-hide {
    display: none;
  }

  .bx-hide,
  .bx-show {
    position: relative;
    left: 92%;
    top: -32px;
  }

  .was-validated .bx-hide,
  .was-validated .bx-show {
    left: 85%;
  }
</style>
</head>

<body>
  <section class="container forms">
    <div class="form login">
      @if(\Session::has('success'))
      <div class="alert alert-primary bg-primary text-center text-light border-0 alert-dismissible fade show"
        role="alert"> {{\Session::get('success')}} </div>
      @endif
      <form action="{{route('login')}}" method="POST" class="needs-validation" novalidate>
        @csrf
        <h1>Welcome back!</h1>
        <p>Please login using your account</p>
        <div class="col-12">
          <label for="email" class="form-label">Email</label>
          <div class="input-group has-validation">
            <input type="email" name="email" class="form-control" id="email" required>
            <div class="invalid-feedback">Please enter your E-mail.</div>
          </div>
        </div>
        <div class="col-12">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" id="password" required>
          <i class='bx bx-show' id="bx-show" onclick="showPassword(1)" style=""></i>
          <i class='bx bx-hide' id="bx-hide" onclick="showPassword(2)" style=""></i>
          <div class="invalid-feedback" id="showPasswordCheckbox">Please enter your password!</div>
        </div>
        <div class="col-12">
          <button class="btn btn-primary w-100" type="submit">Login</button>
          <a href="" style="color: gray; font-size: 14px;">Forget Your Password?</a>
        </div>
      </form>

    </div>
  </section>

  @include('layouts.scripts')
  <script>
    const passwordInput = document.getElementById('password');
    const passwordshow = document.getElementById('bx-show');
    const passwordhide = document.getElementById('bx-hide');
        const showPasswordCheckbox = document.getElementById('showPassword');
        function showPassword(a){
            passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
            if(a === 1){
              passwordshow.style.display = 'none';
              passwordhide.style.display = 'block';
            }
            if(a === 2){
              passwordshow.style.display = 'block';
              passwordhide.style.display = 'none';
            }
          }
  </script>
</body>

</html>