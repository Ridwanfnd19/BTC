<?php 
include_once("../index.php");

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
$delete = $_GET['id'];

$result = mysqli_query($mysqli, "DELETE FROM btc WHERE id='$delete'");

header("Location:tampil.php?page=$page&dari=$tgl_dari&timedari=$time_dari&ke=$tgl_ke&timeke=$time_ke&hargadari=$hargadari&hargake=$hargake&sinyaldari=$sinyaldari&sinyalke=$sinyalke&level=$level&keyword=$keyword&sort=$sort&by=$by");
?>