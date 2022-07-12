<?php 
include_once("../index.php");
$coba = mysqli_query($mysqli, "SELECT * FROM btc ORDER BY id DESC LIMIT 0,10");
$coba1 = mysqli_query($mysqli, "SELECT * FROM btc ORDER BY id DESC LIMIT 0,10");
$query_level = mysqli_query($mysqli, "SELECT * FROM btc ORDER BY id");
while($hasil_level = mysqli_fetch_array($query_level)) {
    $level[] = $hasil_level['level'];
}
$output1[] = array_values(array_unique($level));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BTC</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>BTC</h3>
                </a>
                <div class="navbar-nav w-100">
                    <a href="../dashboard/dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="../tabel/tampil.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
                    <a href="#" class="nav-item nav-link active"><i class="fa fa-chart-bar me-2"></i>Charts</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0" style="height: 64px;">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
            </nav>
            <!-- Navbar End -->


            <!-- Chart Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Single Line Chart</h6>
                            <canvas id="line-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Chart End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/chart/chart.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/tempusdominus/js/moment.min.js"></script>
    <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script>
        // var spinner = function () {
        //     setTimeout(function () {
        //         if ($('#spinner').length > 0) {
        //             $('#spinner').removeClass('show');
        //         }
        //     }, 1);
        // };
        // spinner();

        // Back to top button
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('.back-to-top').fadeIn('slow');
            } else {
                $('.back-to-top').fadeOut('slow');
            }
        });
        $('.back-to-top').click(function () {
            $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
            return false;
        });


        // Sidebar Toggler
        $('.sidebar-toggler').click(function () {
            $('.sidebar, .content').toggleClass("open");
            return false;
        });


        // Progress Bar
        $('.pg-bar').waypoint(function () {
            $('.progress .progress-bar').each(function () {
                $(this).css("width", $(this).attr("aria-valuenow") + '%');
            });
        }, {offset: '80%'});


        // Calender
        $('#calender').datetimepicker({
            inline: true,
            format: 'L'
        });

        // Testimonials carousel
        $(".testimonial-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            items: 1,
            dots: true,
            loop: true,
            nav : false
        });
        const coba_label = [];
        const coba_data = [];
        const level = [];
        <?php while($user_data_chart = mysqli_fetch_array($coba)) : ?>
        coba_label.push(<?php echo '"' . $user_data_chart['level'] . '"' . ', ';?>)
        coba_data.push(<?php echo '"' . $user_data_chart['hargaidr'] . '"' . ', '; ?>)
        <?php endwhile ?>

        <?php
        for ($i = 0; $i < count($output1[0]); $i++) :
        ?>
        level.push(<?php echo '"' . $output1[0][$i] . '"'?>);
        <?php endfor ?>

        // var coba_label = [<?php //while($user_data_chart = mysqli_fetch_array($coba)){
        //             $konter=$user_data_chart['sinyal'];
        //             echo '"' . $user_data_chart['tanggal'] . '"' . ', ';
        //         }?>]
        
        // var coba_data = [<?php //while($user_data_y = mysqli_fetch_array($coba1)){
        //             echo '"' . $user_data_y['hargaidr'] . '"' . ', ';
        //         }?>]

        console.log(coba_data);
        console.log(coba_label);
        console.log(level);
        var URI;
        var ctx3 = $("#line-chart").get(0).getContext("2d");
        var myChart3 = new Chart(ctx3, {
            type: "line",
            data: {
                labels: coba_label,
                datasets: [{
                    label: "coba",
                    fill: false,
                    backgroundColor: "rgba(235, 22, 22, .7)",
                    data: coba_data,
                }]
            },
            options: {
                responsive: true,
                animation : {
                    onComplete : function(){    
                        URI = this.toBase64Image();
                    }
                }
            }
        });
        console.log(URI);
    </script>
</body>

</html>