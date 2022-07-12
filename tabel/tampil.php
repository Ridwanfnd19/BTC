<?php
// $url = $_SERVER['REQUEST_URI'];  
// header("Refresh: 5; URL=$url");  
// //echo "Halaman ini akan direfresh setiap 15 detik</br>";
// echo '<font size=15 color=Blue>Penambangan Sinyal Harian INDODAX</font></br>';

// Create database connection using config file
include_once("../index.php");

$cobalvl = array();

$queryleveldanjenis = mysqli_query($mysqli, "SELECT * FROM btc ORDER by id DESC");

while($user_data = mysqli_fetch_array($queryleveldanjenis)) {
    array_push($cobalvl, $user_data['level']);
}

$hasillevel = array_values(array_unique($cobalvl));

$sort1 = "ASC";
$sort2 = "DESC";

$page = (isset($_GET['page']))? (int) $_GET['page'] : 1;
$keyword = (isset($_GET['keyword']))? $_GET['keyword'] : "";
$tgl_dari = (isset($_GET['dari']))? $_GET['dari'] : "";
$tgl_ke = (isset($_GET['ke']))? $_GET['ke'] : "";
$time_dari = (isset($_GET['timedari']))? $_GET['timedari'] : '00:00:00';
$time_ke = (isset($_GET['timeke']))? $_GET['timeke'] : '00:00:00';
$hargadari = (isset($_GET['hargadari']))? $_GET['hargadari'] : "";
$hargake = (isset($_GET['hargake']))? $_GET['hargake'] : "";
$sinyaldari = (isset($_GET['sinyaldari']))? $_GET['sinyaldari'] : "";
$sinyalke = (isset($_GET['sinyalke']))? $_GET['sinyalke'] : "";
$level = (isset($_GET['level']))? $_GET['level'] : "";
$sort = (isset($_GET['sort']))? $_GET['sort'] : $sort1;
$by = (isset($_GET['by']))? $_GET['by'] : "id";
    
// Jumlah data per halaman
$limit = 100;

$limitStart = ($page - 1) * $limit;
if ($page == 0) {
    $limitStart = 0;
}

$Sql = "SELECT * FROM btc";
$Sql2 = "SELECT * FROM btc";
$Orderby = " ORDER BY "."$by"." $sort";
$kondisi = " LIMIT $limitStart,$limit";
                              
// $SqlQuery = mysqli_query($mysqli, "SELECT * FROM btc LIMIT ".$limitStart.",".$limit);
// $query = mysqli_query($mysqli, "SELECT * FROM btc");

if ($keyword != "") {
    $Sql .= " WHERE level = '$keyword'";
    $Sql2 .= " WHERE level = '$keyword'";
    $level="";
}

if (($level !== "") && ($keyword == "")) {
    $Sql .= " WHERE level = '$level'";
    $Sql2 .= " WHERE level = '$level'";
}

if (($tgl_dari != "") && ($tgl_ke != "")){
    if (($keyword != "") || (($level !== "") && ($keyword == ""))) {
        $Sql .= " AND tanggal BETWEEN "."'$tgl_dari $time_dari'"." AND "."'$tgl_ke $time_ke'";
        $Sql2 .= " AND tanggal BETWEEN "."'$tgl_dari $time_dari'"." AND "."'$tgl_ke $time_ke'";
    } else {
        $Sql .= " WHERE tanggal BETWEEN "."'$tgl_dari $time_dari'"." AND "."'$tgl_ke $time_ke'";
        $Sql2 .= " WHERE tanggal BETWEEN "."'$tgl_dari $time_dari'"." AND "."'$tgl_ke $time_ke'";
    }
}

if (($hargadari != "") && ($hargake != "")){
    if (($keyword != "") || (($tgl_dari != "") && ($tgl_ke != "")) || (($level !== "") && ($keyword == ""))) {
        $Sql .= " AND hargaidr BETWEEN "."$hargadari"." AND "."$hargake";
        $Sql2 .= " AND hargaidr BETWEEN "."$hargadari"." AND "."$hargake";
    } else {
        $Sql .= " WHERE hargaidr BETWEEN "."$hargadari"." AND "."$hargake";
        $Sql2 .= " WHERE hargaidr BETWEEN "."$hargadari"." AND "."$hargake";
    }
}

if (($sinyaldari != "") && ($sinyalke != "")){
    if (($keyword != "") || (($tgl_dari != "") && ($tgl_ke != "")) || ($hargadari != "") && ($hargake != "") || (($level !== "") && ($keyword == ""))) {
        $Sql .= " AND sinyal BETWEEN "."$sinyaldari"." AND "."$sinyalke";
        $Sql2 .= " AND sinyal BETWEEN "."$sinyaldari"." AND "."$sinyalke";
    } else {
        $Sql .= " WHERE sinyal BETWEEN "."$sinyaldari"." AND "."$sinyalke";
        $Sql2 .= " WHERE sinyal BETWEEN "."$sinyaldari"." AND "."$sinyalke";
    }
}

$Sql .= $Orderby;
$Sql .= $kondisi;
$SqlQuery = mysqli_query($mysqli, $Sql);
$query = mysqli_query($mysqli, $Sql2);
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>BTC</h3>
                </a>
                <div class="navbar-nav w-100">
                    <a href="../dashboard/dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="#" class="nav-item nav-link active"><i class="fa fa-table me-2"></i>Tables</a>
                    <a href="../chart/chart.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a>
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
                <a href="../dashboard/dashboard.php" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
            </nav>
            <!-- Navbar Start -->

            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-2">Data Table</h6>
                            <div class="table-responsive">
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown">
                                        <i class="bi bi-funnel-fill"></i>
                                        <span class="d-none d-lg-inline-flex"><b>Filter</b></span>
                                    </a>
                                    <div class="dropdown-menu bg-secondary border-0 rounded-0 rounded-bottom m-0" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="#" onclick="tanggal()"><h6 class="fw-normal mb-0">Tanggal</h6></a>
                                        <hr class="dropdown-divider">
                                        <a class="dropdown-item" href="#" onclick="harga()"><h6 class="fw-normal mb-0">Harga</h6></a>
                                        <hr class="dropdown-divider">
                                        <a class="dropdown-item" href="#" onclick="sinyal()"><h6 class="fw-normal mb-0">Sinyal</h6></a>
                                        <hr class="dropdown-divider">
                                        <a class="dropdown-item" href="#" onclick="level()"><h6 class="fw-normal mb-0">Level</h6></a>
                                    </div>
                                </div>
                                <form>
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-auto" id="tgl" hidden>
                                                <div class="row">
                                                    <div class="col-5">
                                                        <input type="date" class="form-control" name="dari" value="<?php if (isset($_GET['dari']))  echo $_GET['dari']; ?>">
                                                        <input type="time" class="form-control" name="timedari" value="<?php if (isset($_GET['timedari']))  echo $_GET['timedari']; ?>">
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        -
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="date" class="form-control" name="ke" value="<?php if (isset($_GET['ke']))  echo $_GET['ke']; ?>">
                                                        <input type="time" class="form-control" name="timeke" value="<?php if (isset($_GET['timeke']))  echo $_GET['timeke']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto" id="harga" hidden>
                                                <div class="row">
                                                    <div class="col-5">
                                                        <input type="number" class="form-control" name="hargadari" value=<?php if (isset($_GET['hargadari']))  echo $_GET['hargadari']; ?>>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        -
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="number" class="form-control" name="hargake" value=<?php if (isset($_GET['hargake']))  echo $_GET['hargake']; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-auto" id="sinyal" hidden>
                                                <div class = "row">
                                                    <div class="col-5">
                                                        <input type="number" class="form-control" name="sinyaldari" value=<?php if (isset($_GET['sinyaldari']))  echo $_GET['sinyaldari']; ?>>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        -
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="number" class="form-control" name="sinyalke" value=<?php if (isset($_GET['sinyalke']))  echo $_GET['sinyalke']; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="search">
                                            <div class="col-auto">
                                                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Kata kunci.." autofocus value="<?php if (isset($_GET['keyword']))  echo $_GET['keyword']; ?>">
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-primary">Cari</button>
                                                <a href="tampil.php" class="btn btn-danger">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div>
                                    <ul class="pagination">
                                        <!-- LINK FIRST AND PREV -->
                                        <?php
                                        if($page == 1){ // Jika page adalah page ke 1, maka disable link PREV
                                        ?>
                                            <li class="disabled"><a href="#">First</a></li>
                                            <li class="disabled"><a href="#">&laquo;</a></li>
                                        <?php
                                        }else{ // Jika page bukan page ke 1
                                        $LinkPrev = ($page > 1)? $page - 1 : 1;
                                            if (($keyword != "") || (($tgl_dari != "") && ($tgl_ke != "")) || (($hargadari != "") && ($hargake != "")) || (($sinyaldari != "") && ($sinyalke != ""))) : 
                                        ?>
                                            <li><a href="tampil.php?page=1&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>">First</a></li>

                                            <li><a href="tampil.php?page=<?php echo $LinkPrev;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>">&laquo;</a></li>
                                        <?php else :?>
                                            <li><a href="tampil.php?page=1&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>">First</a></li>
                                            <li><a href="tampil.php?page=<?php echo $LinkPrev; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>">&laquo;</a></li>
                                        <?php endif?>
                                        <?php
                                        }
                                        ?>

                                        <!-- LINK NUMBER -->
                                        <?php      
                                        
                                        //Hitung semua jumlah data yang berada pada tabel 
                                        $JumlahData = mysqli_num_rows($query);
                                        if ($JumlahData == 0) {
                                            $page = 0;
                                        } 
                                        
                                        $jumlahPage = ceil($JumlahData / $limit);  // Hitung jumlah halamannya
                                        $jumlahNumber = 2; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                                        $startNumber = ($page > $jumlahNumber)? $page - $jumlahNumber : 1; // Untuk awal link number
                                        $endNumber = ($page < ($jumlahPage - $jumlahNumber))? $page + $jumlahNumber : $jumlahPage; // Untuk akhir link number
                                        
                                        for($i = $startNumber; $i <= $endNumber; $i++){
                                            $linkActive = ($page == $i)? ' class="active"' : '';
                                            if (($keyword != "") || (($tgl_dari != "") && ($tgl_ke != "")) || (($hargadari != "") && ($hargake != "")) || (($sinyaldari != "") && ($sinyalke != ""))) :
                                        ?>
                                            <li<?php echo $linkActive; ?>><a href="tampil.php?page=<?php echo $i;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>"><?php echo $i; ?></a></li>
                                        <?php else :?>
                                            <li<?php echo $linkActive; ?>><a href="tampil.php?page=<?php echo $i;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>"><?php echo $i; ?></a></li>
                                        <?php endif?>
                                        <?php
                                        }
                                        ?>

                                        <!-- LINK NEXT AND LAST -->
                                        <?php
                                        // Jika page sama dengan jumlah page, maka disable link NEXT nya
                                        // Artinya page tersebut adalah page terakhir 
                                        if($page == $jumlahPage){ // Jika page terakhir
                                        ?>
                                        <li class="disabled"><a href="#">&raquo;</a></li>
                                        <li class="disabled"><a href="#">Last</a></li>
                                        <?php
                                        }else{ // Jika Bukan page terakhir
                                        $link_next = ($page < $jumlahPage)? $page + 1 : $jumlahPage;
                                            if (($keyword != "") || (($tgl_dari != "") && ($tgl_ke != "")) || (($hargadari != "") && ($hargake != "")) || (($sinyaldari != "") && ($sinyalke != ""))) :
                                        ?>
                                            <li><a href="tampil.php?page=<?php echo $link_next; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>">&raquo;</a></li>

                                            <li><a href="tampil.php?page=<?php echo $jumlahPage; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>">Last</a></li>
                                        <?php else :?>
                                            <li><a href="tampil.php?page=<?php echo $link_next; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>">&raquo;</a></li>
                                            <li><a href="tampil.php?page=<?php echo $jumlahPage; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>">Last</a></li>
                                        <?php endif?>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <table class="table table-bordered responsive" style="color: white">
                                    <thead>
                                        <tr>
                                            <th>ID<a href="tampil.php?page=<?php echo $page;?>&dari=<?php echo $tgl_dari;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php if(($sort == "DESC") && ($by == "id")){echo $sort1;}else{echo $sort2;}?>&by=id"><i class="<?php if(($sort == "DESC") && ($by == "id")){echo "bi bi-caret-down-fill";}else{echo "bi bi-caret-up-fill";}?>"></i></a></th>
                                            <th>Sinyal<a href="tampil.php?page=<?php echo $page;?>&dari=<?php echo $tgl_dari;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php if(($sort == "DESC") && ($by == "sinyal")){echo $sort1;}else{echo $sort2;}?>&by=sinyal"><i class="<?php if(($sort == "DESC") && ($by == "sinyal")){echo "bi bi-caret-down-fill";}else{echo "bi bi-caret-up-fill";}?>"></i></a></th>
                                            <th>Level<a href="tampil.php?page=<?php echo $page;?>&dari=<?php echo $tgl_dari;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php if(($sort == "DESC") && ($by == "level")){echo $sort1;}else{echo $sort2;}?>&by=level"><i class="<?php if(($sort == "DESC") && ($by == "level")){echo "bi bi-caret-down-fill";}else{echo "bi bi-caret-up-fill";}?>"></i></a></th>
                                            <th>Tanggal dan Waktu<a href="tampil.php?page=<?php echo $page;?>&dari=<?php echo $tgl_dari;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php if(($sort == "DESC") && ($by == "tanggal")){echo $sort1;}else{echo $sort2;}?>&by=tanggal"><i class="<?php if(($sort == "DESC") && ($by == "tanggal")){echo "bi bi-caret-down-fill";}else{echo "bi bi-caret-up-fill";}?>"></i></a></th>
                                            <th>Harga Rp.<a href="tampil.php?page=<?php echo $page;?>&dari=<?php echo $tgl_dari;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php if(($sort == "DESC") && ($by == "hargaidr")){echo $sort1;}else{echo $sort2;}?>&by=hargaidr"><i class="<?php if(($sort == "DESC") && ($by == "hargaidr")){echo "bi bi-caret-down-fill";}else{echo "bi bi-caret-up-fill";}?>"></i></a></th>
                                            <th>Harga USDT<a href="tampil.php?page=<?php echo $page;?>&dari=<?php echo $tgl_dari;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php if(($sort == "DESC") && ($by == "hargausdt")){echo $sort1;}else{echo $sort2;}?>&by=hargausdt"><i class="<?php if(($sort == "DESC") && ($by == "hargausdt")){echo "bi bi-caret-down-fill";}else{echo "bi bi-caret-up-fill";}?>"></i></a></th> 
                                            <th>Vol BTC<a href="tampil.php?page=<?php echo $page;?>&dari=<?php echo $tgl_dari;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php if(($sort == "DESC") && ($by == "volidr")){echo $sort1;}else{echo $sort2;}?>&by=volidr"><i class="<?php if(($sort == "DESC") && ($by == "volidr")){echo "bi bi-caret-down-fill";}else{echo "bi bi-caret-up-fill";}?>"></i></a></th> 
                                            <th>Vol Rp.<a href="tampil.php?page=<?php echo $page;?>&dari=<?php echo $tgl_dari;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php if(($sort == "DESC") && ($by == "volusdt")){echo $sort1;}else{echo $sort2;}?>&by=volusdt"><i class="<?php if(($sort == "DESC") && ($by == "volusdt")){echo "bi bi-caret-down-fill";}else{echo "bi bi-caret-up-fill";}?>"></i></a></th> 
                                            <th>Last Buy<a href="tampil.php?page=<?php echo $page;?>&dari=<?php echo $tgl_dari;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php if(($sort == "DESC") && ($by == "lastbuy")){echo $sort1;}else{echo $sort2;}?>&by=lastbuy"><i class="<?php if(($sort == "DESC") && ($by == "lastbuy")){echo "bi bi-caret-down-fill";}else{echo "bi bi-caret-up-fill";}?>"></i></a></th> 
                                            <th>Last Sell<a href="tampil.php?page=<?php echo $page;?>&dari=<?php echo $tgl_dari;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php if(($sort == "DESC") && ($by == "lastsell")){echo $sort1;}else{echo $sort2;}?>&by=lastsell"><i class="<?php if(($sort == "DESC") && ($by == "lastsell")){echo "bi bi-caret-down-fill";}else{echo "bi bi-caret-up-fill";}?>"></i></a></th> 
                                            <th>Jenis<a href="tampil.php?page=<?php echo $page;?>&dari=<?php echo $tgl_dari;?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php if(($sort == "DESC") && ($by == "jenis")){echo $sort1;}else{echo $sort2;}?>&by=jenis"><i class="<?php if(($sort == "DESC") && ($by == "jenis")){echo "bi bi-caret-down-fill";}else{echo "bi bi-caret-up-fill";}?>"></i></a></th> 
                                            <th>Edit/Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($user_data = mysqli_fetch_array($SqlQuery)) : 
                                            $konter=$user_data['sinyal'];                    
                                        ?>
                                        <tr>
                                            <?php
                                                $hrgidr=number_format($user_data['hargaidr']);
                                                $hrgusdt=number_format($user_data['hargausdt']);
                                                $vidr=number_format($user_data['volusdt']);
                                                $vusdt=number_format($user_data['volidr'],8,",",".");
                                                $lbuy=number_format($user_data['lastbuy']);
                                                $lsell=number_format($user_data['lastsell']);

                                                if($konter>=120) :
                                            ?>
                                            <td data-header="Id" style="background-color: #FF0000;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #FF0000;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #FF0000;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #FF0000;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #FF0000;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #FF0000;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #FF0000;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #FF0000;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #FF0000;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #FF0000;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #FF0000;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #FF0000;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>

                                            <?php elseif ($konter>=111):?>
                                            <td data-header="Id" style="background-color: #FF4500;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #FF4500;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #FF4500;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #FF4500;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #FF4500;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #FF4500;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #FF4500;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #FF4500;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #FF4500;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #FF4500;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #FF4500;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #FF4500;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>

                                            <?php elseif ($konter>=101):?>
                                            <td data-header="Id" style="background-color: #FFA500;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #FFA500;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #FFA500;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #FFA500;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #FFA500;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #FFA500;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #FFA500;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #FFA500;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #FFA500;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #FFA500;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #FFA500;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #FFA500;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>

                                            <?php elseif ($konter>=91):?>
                                            <td data-header="Id" style="background-color: #E52A2A;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #E52A2A;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #E52A2A;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #E52A2A;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #E52A2A;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #E52A2A;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #E52A2A;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #E52A2A;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #E52A2A;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #E52A2A;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #E52A2A;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #E52A2A;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>

                                            <?php elseif ($konter>=81):?>
                                            <td data-header="Id" style="background-color: #F20082;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #F20082;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #F20082;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #F20082;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #F20082;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #F20082;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #F20082;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #F20082;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #F20082;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #F20082;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #F20082;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #F20082;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>

                                            <?php elseif ($konter>=71):?>
                                            <td data-header="Id" style="background-color: #DC5C5C;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #DC5C5C;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #DC5C5C;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #DC5C5C;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #DC5C5C;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #DC5C5C;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #DC5C5C;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #DC5C5C;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #DC5C5C;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #DC5C5C;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #DC5C5C;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #DC5C5C;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>

                                            <?php elseif ($konter>=61):?>
                                            <td data-header="Id" style="background-color: #FF69B4;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #FF69B4;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #FF69B4;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #FF69B4;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #FF69B4;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #FF69B4;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #FF69B4;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #FF69B4;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #FF69B4;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #FF69B4;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #FF69B4;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #FF69B4;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>

                                            <?php elseif ($konter>=51):?>
                                            <td data-header="Id" style="background-color: #F08080;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #F08080;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #F08080;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #F08080;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #F08080;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #F08080;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #F08080;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #F08080;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #F08080;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #F08080;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #F08080;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #F08080;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>

                                            <?php elseif ($konter>=41):?>
                                            <td data-header="Id" style="background-color: #FFA07A;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #FFA07A;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #FFA07A;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #FFA07A;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #FFA07A;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #FFA07A;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #FFA07A;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #FFA07A;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #FFA07A;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #FFA07A;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #FFA07A;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #FFA07A;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>

                                            <?php elseif ($konter>=31):?>
                                            <td data-header="Id" style="background-color: #9370D8;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #9370D8;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #9370D8;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #9370D8;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #9370D8;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #9370D8;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #9370D8;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #9370D8;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #9370D8;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #9370D8;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #9370D8;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #9370D8;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>

                                            <?php elseif ($konter>=21):?>
                                            <td data-header="Id" style="background-color: #BA55D3;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #BA55D3;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #BA55D3;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #BA55D3;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #BA55D3;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #BA55D3;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #BA55D3;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #BA55D3;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #BA55D3;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #BA55D3;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #BA55D3;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #BA55D3;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>

                                            <?php elseif ($konter>=11):?>
                                            <td data-header="Id" style="background-color: #66CDAA;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #66CDAA;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #66CDAA;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #66CDAA;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #66CDAA;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #66CDAA;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #66CDAA;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #66CDAA;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #66CDAA;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #66CDAA;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #66CDAA;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #66CDAA;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>

                                            <?php elseif ($konter>=1):?>
                                            <td data-header="Id" style="background-color: #32CD32;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #32CD32;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #32CD32;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #32CD32;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #32CD32;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #32CD32;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #32CD32;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #32CD32;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #32CD32;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #32CD32;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #32CD32;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #32CD32;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>

                                            <?php else:?>
                                            <td data-header="Id" style="background-color: #00FF00;" ><?php echo $user_data['id']?></td>
                                            <td data-header="Sinyal" style="background-color: #00FF00;" ><?php echo $user_data['sinyal']?></td>
                                            <td data-header="Level" style="background-color: #00FF00;" ><?php echo $user_data['level']?></td>
                                            <td data-header="Tanggal" style="background-color: #00FF00;" ><?php echo $user_data['tanggal']?></td>
                                            <td data-header="Harga Rp." style="background-color: #00FF00;" ><?php echo $hrgidr?></td>
                                            <td data-header="Harga USDT" style="background-color: #00FF00;" ><?php echo $hrgusdt?></td>
                                            <td data-header="Vol BTC" style="background-color: #00FF00;" ><?php echo $vidr?></td>
                                            <td data-header="Vol Rp." style="background-color: #00FF00;" ><?php echo $vusdt?></td>
                                            <td data-header="Last Buy" style="background-color: #00FF00;" ><?php echo $lbuy?></td>
                                            <td data-header="Last Sell" style="background-color: #00FF00;" ><?php echo $lsell?></td>
                                                <?php if($user_data['jenis']=='crash'):?>
                                                    <td data-header="Jenis" style="background-color: red;"><?php echo $user_data['jenis']?></td>
                                                <?php elseif($user_data['jenis']=='moon'):?>
                                                    <td data-header="Jenis" style="background-color: green;"><?php echo $user_data['jenis']?></td>
                                                <?php else: ?>
                                                    <td data-header="Jenis" style="background-color: #00FF00;"></td>
                                                <?php endif?>
                                            <td data-header="Edit/Delete" style="background-color: #00FF00;" >
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $user_data['id'];?>">
                                                    Edit
                                                </button>
                                                <a href="delete.php?id=<?php echo $user_data['id']?>&page=<?php echo $page; ?>&dari=<?php echo $tgl_dari;?>&timedari=<?php echo $time_dari;?>&ke=<?php echo $tgl_ke;?>&timeke=<?php echo $time_ke;?>&hargadari=<?php echo $hargadari;?>&hargake=<?php echo $hargake;?>&sinyaldari=<?php echo $sinyaldari;?>&sinyalke=<?php echo $sinyalke;?>&level=<?php echo $level;?>&keyword=<?php echo $keyword;?>&sort=<?php echo $sort?>&by=<?php echo $by?>" class="btn btn-danger">Delete</a>
                                            </td>
                                            <?php endif?>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop<?php echo $user_data['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel" style="color: black;">Edit Data</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action='<?php echo "edit.php?page=$page&dari=$tgl_dari&timedari=$time_dari&ke=$tgl_ke&timeke=$time_ke&hargadari=$hargadari&hargake=$hargake&sinyaldari=$sinyaldari&sinyalke=$sinyalke&level=$level&keyword=$keyword&sort=$sort&by=$by";?>' method="post">
                                                        <div class="modal-body">                                       
                                                            <div class="row g-3 pb-4 fw-bold">
                                                                <input name="noid" value="<?php echo $user_data['id']; ?>" class="form-control" hidden>
                                                                <div class="form-group">
                                                                    <label>Jenis</label>
                                                                    <select class="form-select" name="jenis">
                                                                        <option value="" selected>--</option>
                                                                        <option value="moon">moon</option>
                                                                        <option value="crash">crash</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Sinyal</label>
                                                                    <input type="number" name="sinyal" class="form-control" value="<?php echo $user_data['sinyal']; ?>">      
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Level</label>
                                                                    <select class="form-select" name="level" id="level">
                                                                        <option value="" selected>--</option>
                                                                        <?php
                                                                        for ($i = 0; $i<count($hasillevel); $i++) :
                                                                            if ($user_data['level'] === $hasillevel[$i]) :
                                                                        ?>
                                                                        <option value="<?php echo $hasillevel[$i];?>" selected><?php echo $hasillevel[$i];?></option>
                                                                        <?php else :?>
                                                                        <option value="<?php echo $hasillevel[$i];?>"><?php echo $hasillevel[$i];?></option>
                                                                        <?php endif?>
                                                                        <?php endfor?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Waktu</label>
                                                                    <input type="time" name="waktu" class="form-control">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Tanggal</label>
                                                                    <input type="date" name="tanggal" class="form-control">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Harga Rp</label>
                                                                    <input type="number" name="hargarp" class="form-control" value="<?php echo $user_data['hargaidr']; ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Harga USDT</label>
                                                                    <input type="number" name="hargausdt" class="form-control" value="<?php echo $user_data['hargausdt']; ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Vol Rp</label>
                                                                    <input type="number" name="volrp" class="form-control" value="<?php echo $user_data['volidr']; ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Vol BTC</label>
                                                                    <input type="number" name="volusdt" class="form-control" value="<?php echo $user_data['volusdt']; ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Last Buy</label>
                                                                    <input type="number" name="buy" class="form-control" value="<?php echo $user_data['lastbuy']; ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Last Sell</label>
                                                                    <input type="number" name="sell" class="form-control" value="<?php echo $user_data['lastsell']; ?>">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" id="save" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endwhile?>   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="../lib/chart/chart.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/tempusdominus/js/moment.min.js"></script>
    <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="../js/jquery.autocomplete.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>