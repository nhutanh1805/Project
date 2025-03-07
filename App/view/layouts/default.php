<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= $this->e($title) ?></title>

  <!-- Styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="/css/trangchu.css" rel="stylesheet">


  <?= $this->section("page_specific_css") ?>
  <style>
 body {
  background-color: #fff; /* Màu trắng cho nền toàn bộ trang */
  color: #333; /* Màu chữ đen để dễ đọc trên nền sáng */
}

</style>
</head>

<body">
  <header>
    <!-- Phần tiêu đề -->
    <div class="p-2 text-center bg-white border-bottom">
      <div class="container">
        <div class="row">
          <!-- Phần logo -->
          <div class="col-md-3 d-flex justify-content-center justify-content-md-start mb-3 mb-md-0">
            <a href="#!" class="ms-md-2">
              <img class="logo" src="/img/horus.png" height="100" />
            </a>
          </div>
          <!-- Phần thanh tìm kiếm -->
          <div class="col-md-6 d-flex justify-content-center align-items-center mb-3 mb-md-0">
  <form action="/search" method="GET" class="d-flex w-100">
    <input type="text" class="form-control rounded-start border-0 shadow-sm px-3 py-2" name="query" placeholder="Tìm kiếm sản phẩm..." required>
    <button type="submit" class="btn btn-primary ms-2 d-lg-flex px-4 py-2 rounded-end shadow-lg transition-all">
      <i class="fas fa-search"></i>
    </button>
  </form>
</div>



         <!-- Phần các biểu tượng và menu dropdown -->
<div class="col-md-3 d-flex justify-content-center justify-content-md-end align-items-center">
  <div class="d-flex">
    <!-- Biểu tượng giỏ hàng -->
    <a class="text-reset ms-3 position-relative" href="/cart">
      <i class="fas fa-shopping-cart fa-lg"></i>
      <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle p-1">1</span>
    </a>

    <!-- Biểu tượng thông báo -->
    <div class="dropdown ms-3">
      <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell fa-lg"></i>
      </a>
      <ul class="dropdown-menu shadow-lg rounded-3">
        <li><a class="dropdown-item" href="#">Some news</a></li>
        <li><a class="dropdown-item" href="#">Another news</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
      </ul>
    </div>
  </div>


  <!-- Biểu tượng ngôn ngữ -->
  <div class="dropdown ms-3">
    <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fa-solid fa-language fa-lg"></i>
    </a>
    <ul class="dropdown-menu shadow-lg rounded-3">
      <li><a class="dropdown-item" href="#">English</a></li>
      <li><a class="dropdown-item" href="#">Polski</a></li>
      <li><a class="dropdown-item" href="#">中文</a></li>
      <li><a class="dropdown-item" href="#">日本語</a></li>
      <li><a class="dropdown-item" href="#">iDeutsch</a></li>
      <li><a class="dropdown-item" href="#">Français</a></li>
      <li><a class="dropdown-item" href="#">Español</a></li>
      <li><a class="dropdown-item" href="#">Русский</a></li>
      <li><a class="dropdown-item" href="#">Português</a></li>
    </ul>
  </div>
</div>



   <!-- Câu giới thiệu về cửa hàng với hiệu ứng chạy và chữ lớn hơn -->
   <marquee class="mt-2 text-muted fs-4" behavior="scroll" direction="left" scrollamount="5">
  💎 <strong>Horus Shop</strong> – đỉnh cao thời thượng,  
  Công nghệ hội tụ, dẫn đường tương lai.  
  🌟 <strong>Laptop</strong> bền bỉ, dáng hình sang,  
  Đẳng cấp dẫn lối, vững vàng bước đi.  
  📱 <strong>Điện thoại</strong> sắc nét diệu kỳ,  
  Trải nghiệm mượt lướt, tinh vi từng giờ.  
  📟 <strong>Máy tính bảng</strong> – nét say sưa,  
  Học hành, công việc, chẳng thừa phút giây.  
  ⌚ <strong>Đồng hồ</strong> đẳng cấp trên tay,  
  Kiêu sa một nét, tầm này ai hơn? ✨  
</marquee>

    <!-- Phần menu điều hướng -->
    
    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-2">
  <div class="container-fluid mt-2">
    <button class="navbar-toggler mb-3" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item ms-1">
          <a class="btn btn-primary text-white shadow-sm px-3 py-2 d-flex align-items-center" href="/">
            <i class="fa-solid fa-house me-2"></i> TRANG CHỦ
          </a>
        </li>
        <li class="nav-item ms-1">
          <a class="btn btn-success text-white shadow-sm px-3 py-2 d-flex align-items-center" href="/product">
            <i class="fa-brands fa-product-hunt me-2"></i> SẢN PHẨM
          </a>
        </li>
        <li class="nav-item ms-1">
          <a class="btn btn-danger text-white shadow-sm px-3 py-2 d-flex align-items-center" href="/homeAmin">
            <i class="fa-solid fa-house me-2"></i> TRANG CHỦ ADMIN
          </a>
        </li>
      <!-- Tài khoản -->
      <li class="nav-item ms-1 dropdown">
          <a class="btn btn-info text-white shadow-sm px-3 py-2 d-flex align-items-center dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-user me-2"></i> TÀI KHOẢN
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php if (!AUTHGUARD()->isUserLoggedIn()) : ?>
              <li><a class="dropdown-item" href="/login">Đăng Nhập</a></li>
              <li><a class="dropdown-item" href="/register">Đăng Ký</a></li>
            <?php else : ?>
              <li><a class="dropdown-item" href="/account">Quản lý tài khoản</a></li>
              <li><a class="dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng Xuất</a></li>
              <form id="logout-form" class="d-none" action="/logout" method="POST"></form>
            <?php endif ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>


            <!-- <li class="nav-item ms-1 w-auto">
              <a class="nav-link" href="/register"><i class="fa-solid fa-pen me-1"></i>ĐĂNG KÝ</a>
            </li>
            <li class="nav-item ms-1 w-auto">
              <a class="nav-link" href="/login"><i class="fa-solid fa-user me-1"></i>ĐĂNG NHẬP</a>
            </li> -->
          
          </ul>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <!-- Left Side Of Navbar -->
        <div class="navbar-nav">
          &nbsp;
        </div>
        <ul class="navbar-nav ms-auto">
     
  </header>

  <?= $this->section("page") ?>

  <!-- END CHANGEABLE CONTENT. -->
  <footer class="text-center text-lg-start text-white mt-4" style="background-color: #45526e">
    <div class="container p-4 pb-0">
      <section class="">
        <div class="row">
          <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">
              Slogan
            </h6>
            <p>
            <p>
              Khám phá vũ trụ công nghệ đầy sức sống, nơi mỗi sản phẩm là một tác phẩm nghệ thuật và là chìa khóa mở ra những trải nghiệm đỉnh cao. Hãy để chúng tôi đồng hành cùng bạn trên hành trình chinh phục tương lai – nơi không có giới hạn cho sự sáng tạo!
            </p>
          </div>

          <hr class="w-100 clearfix d-md-none" />


          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">Products</h6>
            <p>
              <a class="text-white " href="#laptops">LapTop</a>
            </p>
            <p>
              <a class="text-white">Tablet</a>
            </p>
            <p>
              <a class="text-white">Clock</a>
            </p>
            <p>
              <a class="text-white">Smart Phone</a>
            </p>
          </div>

          <hr class="w-100 clearfix d-md-none" />

          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">
              Useful links
            </h6>
            <p>
              <a class="text-white">Your Account</a>
            </p>
            <p>
              <a class="text-white">Become an Affiliate</a>
            </p>
            <p>
              <a class="text-white">Shipping Rates</a>
            </p>
            <p>
              <a class="text-white">Help</a>
            </p>
          </div>

          <hr class="w-100 clearfix d-md-none" />

          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">Contact</h6>
            <p><i class="fas fa-home mr-3"></i> New York, NY 10012, US</p>
            <p><i class="fas fa-envelope mr-3"></i> info@gmail.com</p>
            <p><i class="fas fa-phone mr-3"></i> + 01 234 567 88</p>
            <p><i class="fas fa-print mr-3"></i> + 01 234 567 89</p>
          </div>
        </div>
      </section>

      <hr class="my-3">

      <section class="p-3 pt-0">
        <div class="row d-flex align-items-center">
          <div class="col-md-7 col-lg-8 text-center text-md-start">
            <div class="p-3">
              © 2025 Copyright:
              <a class="text-white" href="https://mdbootstrap.com/">Horus.com</a>
            </div>
          </div>

          <div class="col-md-5 col-lg-4 ml-lg-0 text-center text-md-end">
            <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i
                class="fab fa-facebook-f"></i></a>

            <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i
                class="fab fa-twitter"></i></a>

            <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i
                class="fab fa-google"></i></a>

            <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i
                class="fab fa-instagram"></i></a>
          </div>
        </div>
      </section>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Lấy tất cả các liên kết danh mục
      const categoryLinks = document.querySelectorAll('.list-group-item');

      // Thêm sự kiện click cho từng liên kết
      categoryLinks.forEach(link => {
        link.addEventListener('click', function(event) {
          event.preventDefault();
          const categoryId = this.getAttribute('href').substring(1);
          const section = document.getElementById(categoryId);

          // Cuộn mượt đến phần mục tiêu
          section.scrollIntoView({
            behavior: 'smooth'
          });
        });
      });
    });
  </script>
  <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<script>
  let table = new DataTable('#contacts', {
    responsive: true,
    pagingType: 'simple_numbers'
  });
</script>

<script>
    window.onscroll = function(){
    if(document.documentElement.scrollTop > 100){
      document.querySelector('.backtop').classList.add('activeT');
    }else{
      document.querySelector('.backtop').classList.remove('activeT');
    }
  }
</script>
  </body>

</html>