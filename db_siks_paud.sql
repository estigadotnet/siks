-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 14 Agu 2020 pada 08.41
-- Versi Server: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_siks_paud`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t000_sekolah`
--

CREATE TABLE `t000_sekolah` (
  `id` int(11) NOT NULL,
  `kode` varchar(2) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t000_sekolah`
--

INSERT INTO `t000_sekolah` (`id`, `kode`, `nama`) VALUES
(1, '03', 'KBNU BOJONEGORO');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t001_tahunajaran`
--

CREATE TABLE `t001_tahunajaran` (
  `idtahunajaran` int(5) NOT NULL,
  `tahunajaran` varchar(40) NOT NULL,
  `saldoawal` float(14,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t001_tahunajaran`
--

INSERT INTO `t001_tahunajaran` (`idtahunajaran`, `tahunajaran`, `saldoawal`) VALUES
(1, '2020/2021', 0.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t002_guru`
--

CREATE TABLE `t002_guru` (
  `idguru` int(5) NOT NULL,
  `namaguru` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `t002_guru`
--

INSERT INTO `t002_guru` (`idguru`, `namaguru`) VALUES
(1, 'Sutiyoso'),
(2, 'Djarot Saiful Hidayat'),
(3, 'Fauzi Bowo'),
(5, 'Soerjadi Soedirdja'),
(6, 'Wiyogo Atmodarminto'),
(7, 'Soeprapto'),
(8, 'Nono Taryono');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t003_kelas`
--

CREATE TABLE `t003_kelas` (
  `idkelas` int(11) NOT NULL,
  `kelas` varchar(25) NOT NULL,
  `idguru` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `t003_kelas`
--

INSERT INTO `t003_kelas` (`idkelas`, `kelas`, `idguru`) VALUES
(1, 'KELOMPOK BERMAIN', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t004_siswa`
--

CREATE TABLE `t004_siswa` (
  `idsiswa` int(10) NOT NULL,
  `nis` varchar(10) NOT NULL,
  `namasiswa` varchar(40) NOT NULL,
  `idkelas` int(11) NOT NULL,
  `tahunajaran` varchar(10) NOT NULL,
  `byrspp` int(20) NOT NULL,
  `byrcatering` int(20) NOT NULL,
  `byrworksheet` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `t004_siswa`
--

INSERT INTO `t004_siswa` (`idsiswa`, `nis`, `namasiswa`, `idkelas`, `tahunajaran`, `byrspp`, `byrcatering`, `byrworksheet`) VALUES
(1, '03200320', 'MUHAMMAD ROBITHUL HAQ', 1, '2020/2021', 150000, 0, 0),
(2, '03200322', 'MUHAMMAD ALVIAN MALIK AKBAR', 1, '2020/2021', 150000, 0, 0),
(3, '03200323', 'FARDAN HILMI AZ-ZAHIR', 1, '2020/2021', 150000, 0, 0),
(4, '03200324', 'ALEXAMARA PUTRI ELNAJIYA', 1, '2020/2021', 150000, 0, 0),
(5, '03200325', 'ARKA RAHARDYAN RADIPTA', 1, '2020/2021', 150000, 0, 0),
(6, '03200326', 'ZULHILMI ADZIKRI', 1, '2020/2021', 150000, 0, 0),
(7, '03200327', 'SYAFID ASYIRANI AZHAR', 1, '2020/2021', 150000, 0, 0),
(8, '03200328', 'JAZILA HUWAIDA RIDWAN', 1, '2020/2021', 0, 0, 0),
(9, '03200329', 'AHMAD AIRLANGGA ABIDZAR AL GHIFARI', 1, '2020/2021', 150000, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t005_nonrutin`
--

CREATE TABLE `t005_nonrutin` (
  `id` int(11) NOT NULL,
  `Jenis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t005_nonrutin`
--

INSERT INTO `t005_nonrutin` (`id`, `Jenis`) VALUES
(1, 'Dana Pengembangan Pendidikan'),
(2, 'Daftar Ulang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t101_spp`
--

CREATE TABLE `t101_spp` (
  `idspp` int(10) NOT NULL,
  `idsiswa` int(10) NOT NULL,
  `jatuhtempo` date NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `nobayar` varchar(10) NOT NULL,
  `tglbayar` date NOT NULL,
  `byrspp` int(20) NOT NULL,
  `byrcatering` int(20) NOT NULL,
  `byrworksheet` int(20) NOT NULL,
  `ket` varchar(20) NOT NULL,
  `idadmin` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `t101_spp`
--

INSERT INTO `t101_spp` (`idspp`, `idsiswa`, `jatuhtempo`, `bulan`, `nobayar`, `tglbayar`, `byrspp`, `byrcatering`, `byrworksheet`, `ket`, `idadmin`) VALUES
(1, 1, '2020-07-01', 'Juli 2020', '2008120002', '2020-08-12', 150000, 0, 0, 'LUNAS', 1),
(2, 1, '2020-08-01', 'Agustus 2020', '2008120003', '2020-08-12', 150000, 0, 0, 'LUNAS', 1),
(3, 1, '2020-09-01', 'September 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(4, 1, '2020-10-01', 'Oktober 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(5, 1, '2020-11-01', 'Nopember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(6, 1, '2020-12-01', 'Desember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(7, 1, '2021-01-01', 'Januari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(8, 1, '2021-02-01', 'Februari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(9, 1, '2021-03-01', 'Maret 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(10, 1, '2021-04-01', 'April 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(11, 1, '2021-05-01', 'Mei 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(12, 1, '2021-06-01', 'Juni 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(13, 2, '2020-07-01', 'Juli 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(14, 2, '2020-08-01', 'Agustus 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(15, 2, '2020-09-01', 'September 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(16, 2, '2020-10-01', 'Oktober 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(17, 2, '2020-11-01', 'Nopember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(18, 2, '2020-12-01', 'Desember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(19, 2, '2021-01-01', 'Januari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(20, 2, '2021-02-01', 'Februari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(21, 2, '2021-03-01', 'Maret 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(22, 2, '2021-04-01', 'April 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(23, 2, '2021-05-01', 'Mei 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(24, 2, '2021-06-01', 'Juni 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(25, 3, '2020-07-01', 'Juli 2020', '2008120004', '2020-08-12', 150000, 0, 0, 'LUNAS', 1),
(26, 3, '2020-08-01', 'Agustus 2020', '2008120005', '2020-08-12', 150000, 0, 0, 'LUNAS', 1),
(27, 3, '2020-09-01', 'September 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(28, 3, '2020-10-01', 'Oktober 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(29, 3, '2020-11-01', 'Nopember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(30, 3, '2020-12-01', 'Desember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(31, 3, '2021-01-01', 'Januari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(32, 3, '2021-02-01', 'Februari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(33, 3, '2021-03-01', 'Maret 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(34, 3, '2021-04-01', 'April 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(35, 3, '2021-05-01', 'Mei 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(36, 3, '2021-06-01', 'Juni 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(37, 4, '2020-07-01', 'Juli 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(38, 4, '2020-08-01', 'Agustus 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(39, 4, '2020-09-01', 'September 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(40, 4, '2020-10-01', 'Oktober 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(41, 4, '2020-11-01', 'Nopember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(42, 4, '2020-12-01', 'Desember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(43, 4, '2021-01-01', 'Januari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(44, 4, '2021-02-01', 'Februari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(45, 4, '2021-03-01', 'Maret 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(46, 4, '2021-04-01', 'April 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(47, 4, '2021-05-01', 'Mei 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(48, 4, '2021-06-01', 'Juni 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(49, 5, '2020-07-01', 'Juli 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(50, 5, '2020-08-01', 'Agustus 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(51, 5, '2020-09-01', 'September 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(52, 5, '2020-10-01', 'Oktober 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(53, 5, '2020-11-01', 'Nopember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(54, 5, '2020-12-01', 'Desember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(55, 5, '2021-01-01', 'Januari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(56, 5, '2021-02-01', 'Februari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(57, 5, '2021-03-01', 'Maret 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(58, 5, '2021-04-01', 'April 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(59, 5, '2021-05-01', 'Mei 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(60, 5, '2021-06-01', 'Juni 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(61, 6, '2020-07-01', 'Juli 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(62, 6, '2020-08-01', 'Agustus 2020', '2008120001', '2020-08-12', 150000, 0, 0, 'LUNAS', 1),
(63, 6, '2020-09-01', 'September 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(64, 6, '2020-10-01', 'Oktober 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(65, 6, '2020-11-01', 'Nopember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(66, 6, '2020-12-01', 'Desember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(67, 6, '2021-01-01', 'Januari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(68, 6, '2021-02-01', 'Februari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(69, 6, '2021-03-01', 'Maret 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(70, 6, '2021-04-01', 'April 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(71, 6, '2021-05-01', 'Mei 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(72, 6, '2021-06-01', 'Juni 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(73, 7, '2020-07-01', 'Juli 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(74, 7, '2020-08-01', 'Agustus 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(75, 7, '2020-09-01', 'September 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(76, 7, '2020-10-01', 'Oktober 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(77, 7, '2020-11-01', 'Nopember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(78, 7, '2020-12-01', 'Desember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(79, 7, '2021-01-01', 'Januari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(80, 7, '2021-02-01', 'Februari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(81, 7, '2021-03-01', 'Maret 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(82, 7, '2021-04-01', 'April 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(83, 7, '2021-05-01', 'Mei 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(84, 7, '2021-06-01', 'Juni 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(85, 8, '2020-07-01', 'Juli 2020', '', '0000-00-00', 0, 0, 0, '', 0),
(86, 8, '2020-08-01', 'Agustus 2020', '', '0000-00-00', 0, 0, 0, '', 0),
(87, 8, '2020-09-01', 'September 2020', '', '0000-00-00', 0, 0, 0, '', 0),
(88, 8, '2020-10-01', 'Oktober 2020', '', '0000-00-00', 0, 0, 0, '', 0),
(89, 8, '2020-11-01', 'Nopember 2020', '', '0000-00-00', 0, 0, 0, '', 0),
(90, 8, '2020-12-01', 'Desember 2020', '', '0000-00-00', 0, 0, 0, '', 0),
(91, 8, '2021-01-01', 'Januari 2021', '', '0000-00-00', 0, 0, 0, '', 0),
(92, 8, '2021-02-01', 'Februari 2021', '', '0000-00-00', 0, 0, 0, '', 0),
(93, 8, '2021-03-01', 'Maret 2021', '', '0000-00-00', 0, 0, 0, '', 0),
(94, 8, '2021-04-01', 'April 2021', '', '0000-00-00', 0, 0, 0, '', 0),
(95, 8, '2021-05-01', 'Mei 2021', '', '0000-00-00', 0, 0, 0, '', 0),
(96, 8, '2021-06-01', 'Juni 2021', '', '0000-00-00', 0, 0, 0, '', 0),
(97, 9, '2020-07-01', 'Juli 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(98, 9, '2020-08-01', 'Agustus 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(99, 9, '2020-09-01', 'September 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(100, 9, '2020-10-01', 'Oktober 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(101, 9, '2020-11-01', 'Nopember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(102, 9, '2020-12-01', 'Desember 2020', '', '0000-00-00', 150000, 0, 0, '', 0),
(103, 9, '2021-01-01', 'Januari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(104, 9, '2021-02-01', 'Februari 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(105, 9, '2021-03-01', 'Maret 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(106, 9, '2021-04-01', 'April 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(107, 9, '2021-05-01', 'Mei 2021', '', '0000-00-00', 150000, 0, 0, '', 0),
(108, 9, '2021-06-01', 'Juni 2021', '', '0000-00-00', 150000, 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t102_pengeluaran`
--

CREATE TABLE `t102_pengeluaran` (
  `id` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `nobuk` varchar(12) NOT NULL,
  `keterangan` text NOT NULL,
  `jumlah` float(14,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t103_nonrutin`
--

CREATE TABLE `t103_nonrutin` (
  `idnonrutin` int(10) NOT NULL,
  `idsiswa` int(10) NOT NULL,
  `nobayar` varchar(10) NOT NULL,
  `tglbayar` date NOT NULL,
  `idjenis` int(11) NOT NULL,
  `nominal` int(20) NOT NULL,
  `bayar` int(20) NOT NULL,
  `sisa` int(20) NOT NULL,
  `idadmin` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t103_nonrutin`
--

INSERT INTO `t103_nonrutin` (`idnonrutin`, `idsiswa`, `nobayar`, `tglbayar`, `idjenis`, `nominal`, `bayar`, `sisa`, `idadmin`) VALUES
(1, 1, '', '0000-00-00', 1, 0, 0, 0, 0),
(2, 1, '', '0000-00-00', 2, 0, 0, 0, 0),
(3, 2, '', '0000-00-00', 1, 0, 0, 0, 0),
(4, 2, '', '0000-00-00', 2, 0, 0, 0, 0),
(5, 3, '', '0000-00-00', 1, 0, 0, 0, 0),
(6, 3, '', '0000-00-00', 2, 0, 0, 0, 0),
(7, 4, '', '0000-00-00', 1, 0, 0, 0, 0),
(8, 4, '', '0000-00-00', 2, 0, 0, 0, 0),
(9, 5, '', '0000-00-00', 1, 0, 0, 0, 0),
(10, 5, '', '0000-00-00', 2, 0, 0, 0, 0),
(11, 6, '', '0000-00-00', 1, 0, 0, 0, 0),
(12, 6, '', '0000-00-00', 2, 0, 0, 0, 0),
(13, 7, '', '0000-00-00', 1, 0, 0, 0, 0),
(14, 7, '', '0000-00-00', 2, 0, 0, 0, 0),
(15, 8, '', '0000-00-00', 1, 0, 0, 0, 0),
(16, 8, '', '0000-00-00', 2, 0, 0, 0, 0),
(17, 9, '', '0000-00-00', 1, 0, 0, 0, 0),
(18, 9, '', '0000-00-00', 2, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$12$M42eCl7pO6RlpcDowu7rZexUrsh73.v/Rp3hWMVrPPB8DCWfTjS2S', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1597387173, 1, 'Admin', 'istrator', 'ADMIN', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t000_sekolah`
--
ALTER TABLE `t000_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t001_tahunajaran`
--
ALTER TABLE `t001_tahunajaran`
  ADD PRIMARY KEY (`idtahunajaran`);

--
-- Indexes for table `t002_guru`
--
ALTER TABLE `t002_guru`
  ADD PRIMARY KEY (`idguru`);

--
-- Indexes for table `t003_kelas`
--
ALTER TABLE `t003_kelas`
  ADD PRIMARY KEY (`idkelas`),
  ADD KEY `fk_guru` (`idguru`);

--
-- Indexes for table `t004_siswa`
--
ALTER TABLE `t004_siswa`
  ADD PRIMARY KEY (`idsiswa`),
  ADD KEY `fk_idkelas` (`idkelas`);

--
-- Indexes for table `t005_nonrutin`
--
ALTER TABLE `t005_nonrutin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t101_spp`
--
ALTER TABLE `t101_spp`
  ADD PRIMARY KEY (`idspp`),
  ADD KEY `fk_siswa` (`idsiswa`),
  ADD KEY `fk_admin` (`idadmin`);

--
-- Indexes for table `t102_pengeluaran`
--
ALTER TABLE `t102_pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t103_nonrutin`
--
ALTER TABLE `t103_nonrutin`
  ADD PRIMARY KEY (`idnonrutin`),
  ADD KEY `idsiswa` (`idsiswa`),
  ADD KEY `idjenis` (`idjenis`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t000_sekolah`
--
ALTER TABLE `t000_sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t001_tahunajaran`
--
ALTER TABLE `t001_tahunajaran`
  MODIFY `idtahunajaran` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t002_guru`
--
ALTER TABLE `t002_guru`
  MODIFY `idguru` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `t003_kelas`
--
ALTER TABLE `t003_kelas`
  MODIFY `idkelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t004_siswa`
--
ALTER TABLE `t004_siswa`
  MODIFY `idsiswa` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `t005_nonrutin`
--
ALTER TABLE `t005_nonrutin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `t101_spp`
--
ALTER TABLE `t101_spp`
  MODIFY `idspp` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
--
-- AUTO_INCREMENT for table `t102_pengeluaran`
--
ALTER TABLE `t102_pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t103_nonrutin`
--
ALTER TABLE `t103_nonrutin`
  MODIFY `idnonrutin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t003_kelas`
--
ALTER TABLE `t003_kelas`
  ADD CONSTRAINT `t003_kelas_ibfk_1` FOREIGN KEY (`idguru`) REFERENCES `t002_guru` (`idguru`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t004_siswa`
--
ALTER TABLE `t004_siswa`
  ADD CONSTRAINT `t004_siswa_ibfk_1` FOREIGN KEY (`idkelas`) REFERENCES `t003_kelas` (`idkelas`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t101_spp`
--
ALTER TABLE `t101_spp`
  ADD CONSTRAINT `t101_spp_ibfk_1` FOREIGN KEY (`idsiswa`) REFERENCES `t004_siswa` (`idsiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t103_nonrutin`
--
ALTER TABLE `t103_nonrutin`
  ADD CONSTRAINT `t103_nonrutin_ibfk_1` FOREIGN KEY (`idsiswa`) REFERENCES `t004_siswa` (`idsiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t103_nonrutin_ibfk_2` FOREIGN KEY (`idjenis`) REFERENCES `t005_nonrutin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
