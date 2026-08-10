<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
  <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">{{ config('app.name') }}</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
          {{ menu('guest-menu', 'utils.guest_menu') }}
      </div>
  </div>
</nav>
<!-- Masthead-->
<header class="masthead">
  <div class="container h-100">
      <div class="row h-100 align-items-center justify-content-center text-center">
          <div class="col-lg-10 align-self-end">
              <h1 class="text-white font-weight-bold">Better Solution For</h1>
              <h1 class="text-white font-weight-bold">Your Business</h1>
              <hr class="divider my-4" />
          </div>
          <div class="col-lg-8 align-self-baseline">
              <h2 class="text-white-75 mb-5">We are team of talanted developers making your story into real world</h2>
              <a class="btn btn-info btn-xl js-scroll-trigger" href="#services">Find More</a>
          </div>
      </div>
  </div>
</header>