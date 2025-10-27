-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2025 at 09:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cerita_rakyat`
--

-- --------------------------------------------------------

--
-- Table structure for table `cerita`
--

CREATE TABLE `cerita` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cerita`
--

INSERT INTO `cerita` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(6, 'Serigala Berbulu Domba', 'Peribahasa “serigala berbulu domba” menggambarkan seseorang yang tampak lembut, ramah, dan dapat dipercaya, namun sesungguhnya menyembunyikan niat jahat di balik sikapnya yang manis. Dalam kehidupan sehari-hari, orang seperti ini sering memanfaatkan kebaikan dan kepercayaan orang lain untuk mencapai tujuan pribadi. Mereka pandai berbicara dan bersikap seolah peduli, padahal yang mereka incar hanyalah keuntungan diri sendiri.\r\n\r\nKiasan ini juga mengajarkan pentingnya untuk tidak menilai seseorang hanya dari penampilan atau tutur katanya. Banyak orang tampak baik di permukaan, tetapi tindakannya menunjukkan hal yang berbeda. Karena itu, kita perlu berhati-hati dalam menaruh kepercayaan kepada orang lain dan belajar mengenali karakter sejati seseorang melalui perbuatan, bukan sekadar kata-kata.\r\n\r\nSelain sebagai peringatan moral, makna serigala berbulu domba juga mengajak kita untuk introspeksi diri. Jangan sampai kita sendiri menjadi seperti serigala yang menipu dengan topeng kebaikan. Kejujuran dan ketulusan adalah nilai yang jauh lebih berharga daripada sekadar citra baik di mata orang lain. Dengan bersikap jujur dan tulus, kita dapat membangun hubungan yang kuat, saling percaya, dan bermakna dengan orang di sekitar kita.', 'img_68ff262c5a22d.png', '2025-10-27 07:58:36'),
(7, 'Kancil dan Buaya', 'Pada suatu hari yang cerah, si Kancil yang cerdik ingin menyeberangi sungai untuk mencari makanan di seberang. Namun, sungai itu penuh dengan buaya yang lapar dan siap memangsa siapa pun yang lewat. Dengan kecerdikannya, Kancil berpura-pura membawa pesan dari Raja Hutan yang ingin menghitung jumlah buaya di sungai. Ia berkata bahwa setiap buaya harus berbaris agar bisa dihitung satu per satu.\r\n\r\nPara buaya yang polos dan tamak percaya pada perkataan Kancil. Mereka segera membentuk barisan panjang dari tepi hingga ke seberang sungai. Tanpa ragu, Kancil melompat di atas punggung mereka satu per satu sambil pura-pura menghitung. Setelah sampai di seberang, Kancil tertawa gembira dan berteriak bahwa ia hanya menipu mereka agar bisa menyeberang tanpa dimakan.\r\n\r\nBuaya-buaya pun marah besar karena telah dibodohi oleh hewan kecil itu, tetapi mereka tidak bisa berbuat apa-apa karena Kancil sudah jauh. Sejak saat itu, Kancil dikenal sebagai hewan yang licik namun cerdas, sementara buaya menjadi simbol dari kekuatan yang mudah dikelabui oleh kepintaran. Cerita ini mengajarkan kita bahwa kecerdikan dan akal yang tajam bisa mengalahkan kekuatan fisik yang besar.', 'img_68ff268a7885d.png', '2025-10-27 08:00:10'),
(8, 'Ayam dan Jarum Emas', 'Pada zaman dahulu, hiduplah seorang perempuan miskin yang bekerja sebagai penjahit. Ia hanya memiliki seekor ayam kesayangan yang selalu menemaninya setiap hari. Suatu ketika, saat sedang menjahit, jarum emas kesayangannya terjatuh dan hilang di halaman. Ia sangat sedih karena jarum itu satu-satunya alat berharganya untuk mencari nafkah. Melihat tuannya bersedih, ayam itu merasa iba dan berjanji akan membantu mencari jarum emas tersebut.\r\n\r\nAyam pun mulai mengais tanah dengan paruh dan cakarnya, berusaha menemukan jarum emas di antara pasir dan bebatuan. Setelah lama mencari, akhirnya ayam menemukan jarum itu tertimbun di dekat akar pohon. Dengan hati gembira, ayam membawa jarum emas itu kepada tuannya. Sang perempuan sangat terharu dan memeluk ayam kesayangannya dengan penuh kasih, berterima kasih karena telah mengembalikan benda berharganya.\r\n\r\nSejak saat itu, perempuan itu semakin menyayangi ayamnya dan merawatnya dengan penuh perhatian. Ia sadar bahwa kebaikan dan ketulusan hati tidak hanya dimiliki manusia, tetapi juga bisa datang dari hewan yang setia. Cerita Jarum Emas dan Ayam mengajarkan kita tentang nilai kesetiaan, ketulusan, dan balasan baik bagi siapa pun yang berbuat kebaikan tanpa pamrih.', 'img_68ff26e77d508.png', '2025-10-27 08:01:43'),
(9, 'Timun Mas', 'Pada zaman dahulu, hiduplah seorang janda tua bernama Mbok Srini yang sangat merindukan kehadiran seorang anak. Suatu hari, datanglah raksasa yang menjanjikan akan memberinya seorang anak, dengan syarat anak itu harus diserahkan kembali saat sudah beranjak dewasa. Mbok Srini yang sangat menginginkan anak pun setuju. Tak lama kemudian, tumbuhlah sebuah timun raksasa di kebunnya, dan ketika dibelah, keluarlah seorang bayi cantik yang diberi nama Timun Mas.\r\n\r\nTahun demi tahun berlalu, Timun Mas tumbuh menjadi gadis yang baik dan cantik. Namun, Mbok Srini terus diliputi ketakutan karena waktunya hampir tiba untuk menyerahkan Timun Mas kepada raksasa. Dengan rasa cemas, ia pergi menemui seorang pertapa sakti yang memberinya empat bungkusan berisi biji mentimun, jarum, garam, dan terasi untuk melindungi Timun Mas. Ketika raksasa datang menagih janji, Timun Mas melarikan diri dan melempar isi bungkusan itu satu per satu.\r\n\r\nSetiap benda yang dilempar berubah menjadi rintangan besar — hutan mentimun, lautan tajam, gunung garam, hingga lahar panas yang akhirnya menelan sang raksasa. Timun Mas pun selamat dan kembali ke pelukan Mbok Srini. Mereka hidup bahagia dan damai selamanya. Cerita Timun Mas mengajarkan bahwa kecerdikan, keberanian, dan doa dapat mengalahkan kekuatan jahat sebesar apa pun.', 'img_68ff2729db5fa.png', '2025-10-27 08:02:49'),
(10, 'Malin Kundang', 'Dahulu kala, di sebuah kampung nelayan di Sumatera Barat, hiduplah seorang janda miskin bersama anak laki-lakinya bernama Malin Kundang. Sejak kecil, Malin tumbuh menjadi anak yang rajin dan patuh kepada ibunya. Ketika dewasa, ia memutuskan untuk merantau agar bisa mengubah nasib dan membahagiakan ibunya. Dengan berat hati, sang ibu melepas kepergian Malin sambil berdoa agar anaknya selamat dan sukses di perantauan.\r\n\r\nBeberapa tahun kemudian, Malin berhasil menjadi saudagar kaya raya dan menikahi seorang gadis cantik dari keluarga bangsawan. Suatu hari, kapalnya berlabuh di kampung halamannya. Sang ibu yang mendengar kabar itu sangat bahagia dan segera mendatangi Malin untuk menyambutnya. Namun, ketika melihat ibunya yang berpakaian lusuh, Malin merasa malu di depan istrinya dan para pengawalnya. Ia bahkan menyangkal bahwa wanita tua itu adalah ibunya sendiri.\r\n\r\nSang ibu yang kecewa dan hancur hatinya kemudian berdoa kepada Tuhan agar Malin diberi pelajaran atas kesombongannya. Tak lama setelah kapalnya berlayar kembali, badai besar datang dan menghantam kapal Malin. Tubuh Malin perlahan berubah menjadi batu di tepi pantai. Batu itu dipercaya masyarakat sebagai wujud penyesalan abadi seorang anak durhaka. Cerita Malin Kundang mengajarkan pentingnya berbakti kepada orang tua dan tidak sombong atas kesuksesan yang dimiliki.', 'img_68ff277351835.png', '2025-10-27 08:03:48');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `cerita_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `cerita_id`, `user_id`, `comment`, `created_at`) VALUES
(7, 9, 2, 'Wah seru banget...', '2025-10-27 08:05:02'),
(8, 10, 3, 'makanya guyss kita harus berbakti dengan orang tua yaa...', '2025-10-27 08:05:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '12345', 'admin'),
(2, 'Ikram', '12345', 'user'),
(3, 'sugar', '12345', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cerita`
--
ALTER TABLE `cerita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cerita_id` (`cerita_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cerita`
--
ALTER TABLE `cerita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`cerita_id`) REFERENCES `cerita` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
