-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Apr 2019 pada 04.40
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.1.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `omnifluencer`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `settings` mediumblob,
  `cookies` mediumblob,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `setting_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `username`, `settings`, `cookies`, `last_modified`, `setting_id`) VALUES
(1810, 'mayymayyaa', 0x7b22646576696365737472696e67223a2232345c2f372e303b203338306470693b203130383078313932303b204f6e65506c75733b204f4e45504c55532041333031303b204f6e65506c757333543b2071636f6d222c226465766963655f6964223a22616e64726f69642d62616535613563643564323161663839222c2270686f6e655f6964223a2235316362636166622d393733342d343039342d626534652d636461353664613236323636222c2275756964223a2234336636373932612d353664382d343737372d383337622d666434303731353731643638222c226164766572746973696e675f6964223a2263376136613966322d323137392d343839652d616436312d383438356361346539303639222c2273657373696f6e5f6964223a2238343062663936632d383234662d346165312d626539632d613435306238306535376461222c226578706572696d656e7473223a225a654e714e564e4675327a414d5c2f42635c2f39324874686d486f7a784379525474455a456b565a61644230485c2f66796246544f646d362b556b516a2b516465664b6c6b59474d74796d49706354475a526d5a4a496b327235656d6c33635333345a334f76495a70793534466333737533507a3275513063664f45416a346b52764a736e4669544a586a696c454c366845524f4a5938514759315771557057456e65497a4a7957747354657449357442664b5379584b506d765631444d35525a475c2f4644395346796566506d42346c347337336b6b6153666a765736555661506b43784a52664d556b516a317767725770695144316c363661374359674b523342304136343354566353716a32734f3431764f314a72754f4353517331526b334975366168667265453973464e58436143576f336b5139684578623678563648775933302b563638457562474442365a795a6635303452712b4b7477324d6d684a61356b4f4c32544269644745693475754750555c2f79437862365854754e6f55444e3456376e6f5a682b6d57585179446a31567a6344365543636b366c4470732b4c3855697375646c557a4d7a7a6a444b695841742b5c2f346274466333616b4446505945767631383863533239776734374b6f6c2b707570584b4c505a64596e467164577454486e73365271585659746f4d4e414c687574766c3471705c2f58384f6130514d746d42623646706371554c73326a365c2f654a7331674f5944794d634268626d754b796d736b4c586730387543757834624148646e756233694e576c6c3969456962705c2f7746426f384c3166374139586d3034676658754a3343506d767a5268354f764876515775436f5c2f685854455c2f324c647a7662346e2b5c2f47317263725844475c2f7a7152316a6e385a32774d3677737a686d6e4e627938647659375c2f724e413d3d222c2266626e735f61757468223a22222c2266626e735f746f6b656e223a22222c226c6173745f66626e735f746f6b656e223a22222c226c6173745f6c6f67696e223a2231353535393030303931222c226c6173745f6578706572696d656e7473223a2231353535393030303936222c226163636f756e745f6964223a2233393633353334393530222c227a725f72756c6573223a224a5b5d222c227a725f746f6b656e223a22222c227a725f65787069726573223a2231353535393431363131227d, 0x5b7b224e616d65223a226d6964222c2256616c7565223a2257697473654141424141484b6867376b353539354f35454436373650222c22446f6d61696e223a22692e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a22363330373230303030222c2245787069726573223a323134333531353235362c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2264735f75736572222c2256616c7565223a226d6179796d6179796161222c22446f6d61696e223a22692e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a2237373736303030222c2245787069726573223a313532303537313237352c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a22727572222c2256616c7565223a22465457222c22446f6d61696e223a22692e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a6e756c6c2c2245787069726573223a6e756c6c2c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2269735f737461727265645f656e61626c6564222c2256616c7565223a22796573222c22446f6d61696e223a22692e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a22363330373230303030222c2245787069726573223a323134333531353237372c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a226967666c222c2256616c7565223a226d6179796d6179796161222c22446f6d61696e223a22692e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a223836343030222c2245787069726573223a313531323838313637372c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2273657373696f6e6964222c2256616c7565223a223339363335333439353025334155735349743773634868567154302533413132222c22446f6d61696e223a22692e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a2237373736303030222c2245787069726573223a313532303537313238302c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a2264735f757365725f6964222c2256616c7565223a2233393633353334393530222c22446f6d61696e223a22692e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a2237373736303030222c2245787069726573223a313532303537313238322c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2275726c67656e222c2256616c7565223a225c227b5c5c5c2274696d655c5c5c223a20313531323739353235385c5c303534205c5c5c22326130613a653534313a386635343a316135643a346635613a383166643a633139393a643561325c5c5c223a203230323737337d3a31654e5839753a58617a5a3767624d3542716154314a543445455a7a4e52644974635c22222c22446f6d61696e223a22692e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a6e756c6c2c2245787069726573223a6e756c6c2c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a226d6964222c2256616c7565223a2257697473654141424141484b6867376b353539354f35454436373650222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a6e756c6c2c2245787069726573223a6e756c6c2c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a226d6364222c2256616c7565223a2233222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a6e756c6c2c2245787069726573223a6e756c6c2c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2264735f75736572222c2256616c7565223a226d6179796d6179796161222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a2237373736303030222c2245787069726573223a313534303730303931322c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2269675f6469726563745f726567696f6e5f68696e74222c2256616c7565223a225c225c22222c22446f6d61696e223a22696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a2230222c2245787069726573223a302c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2269675f6469726563745f726567696f6e5f68696e74222c2256616c7565223a225c225c22222c22446f6d61696e223a22692e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a2230222c2245787069726573223a302c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2269675f6469726563745f726567696f6e5f68696e74222c2256616c7565223a225c225c22222c22446f6d61696e223a222e692e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a2230222c2245787069726573223a302c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2269675f6469726563745f726567696f6e5f68696e74222c2256616c7565223a225c225c22222c22446f6d61696e223a227777772e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a2230222c2245787069726573223a302c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2269675f6469726563745f726567696f6e5f68696e74222c2256616c7565223a225c225c22222c22446f6d61696e223a222e7777772e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a2230222c2245787069726573223a302c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2269735f737461727265645f656e61626c6564222c2256616c7565223a22796573222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a22363330373230303030222c2245787069726573223a323136373838313239322c22536563757265223a66616c73652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2263737266746f6b656e222c2256616c7565223a223065616c366d344d637839564f6f43737a485352626c56584d315a4b68357056222c22446f6d61696e223a22692e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a223331343439363030222c2245787069726573223a313536383631303839332c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2269675f6469726563745f726567696f6e5f68696e74222c2256616c7565223a2250524e222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a22363034383030222c2245787069726573223a313533393932333932332c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a22727572222c2256616c7565223a2250524e222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a6e756c6c2c2245787069726573223a6e756c6c2c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a227368626964222c2256616c7565223a22383734222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a22363034383030222c2245787069726573223a313535363433373839372c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a227368627473222c2256616c7565223a22313535353833333039372e37363730363637222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a22363034383030222c2245787069726573223a313535363433373839372c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a2273657373696f6e6964222c2256616c7565223a2233393633353334393530253341544d5642696d62415148625278692533413137222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a223331353336303030222c2245787069726573223a313538373430353630342c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a226967666c222c2256616c7565223a226d6179796d6179796161222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a223836343030222c2245787069726573223a313535353935363031362c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a2264735f757365725f6964222c2256616c7565223a2233393633353334393530222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a2237373736303030222c2245787069726573223a313536333637363139312c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2275726c67656e222c2256616c7565223a225c227b5c5c5c22323030313a6466353a613030303a326130323a333732313a313038353a3331343a343438345c5c5c223a2032333639315c5c303534205c5c5c22323030313a6466353a613030303a326130323a393634363a373735323a333137393a323036385c5c5c223a2032333639317d3a3168494f694e3a624f6a586762435f46613941415844417a7531325646436d476a735c22222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a6e756c6c2c2245787069726573223a6e756c6c2c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a2263737266746f6b656e222c2256616c7565223a223065616c366d344d637839564f6f43737a485352626c56584d315a4b68357056222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a223331343439363030222c2245787069726573223a313538373334393739312c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d5d, '2019-04-22 02:29:51', NULL),
(1811, 'mayyyvitri', 0x7b22646576696365737472696e67223a2232335c2f362e302e313b203634306470693b203134343078323536303b2073616d73756e673b20534d2d47393335463b206865726f326c74653b2073616d73756e676578796e6f7338383930222c226465766963655f6964223a22616e64726f69642d62376632316234353463396635326535222c2270686f6e655f6964223a2264626332653632352d643262662d346162322d623132352d666133643830316364326536222c2275756964223a2261663939376662632d373636332d343934632d613135392d386266353132303633356532222c226164766572746973696e675f6964223a2266643433353637302d363133342d343734642d623238312d646162313733616432363363222c2273657373696f6e5f6964223a2230626134653632332d373731392d343835612d393734362d326265343734376337346334222c226578706572696d656e7473223a224a7b5c2269675f616e64726f69645f67716c735f747970696e675f696e64696361746f725c223a7b5c2269735f656e61626c65645c223a5c22747275655c227d7d222c2266626e735f61757468223a22222c2266626e735f746f6b656e223a22222c226c6173745f66626e735f746f6b656e223a22222c226c6173745f6c6f67696e223a2231353535393837313836222c226c6173745f6578706572696d656e7473223a2231353535393836383633222c226461746163656e746572223a22222c2270726573656e63655f64697361626c6564223a22222c227a725f746f6b656e223a22222c227a725f65787069726573223a2231353536303538383637222c227a725f72756c6573223a224a5b5d222c226163636f756e745f6964223a2233393632313436303631227d, 0x5b7b224e616d65223a226d6964222c2256616c7565223a22584c353571674142414145697279417962594c55384f517a51735778222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a22333135333630303030222c2245787069726573223a313837313334363835382c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2264735f75736572222c2256616c7565223a226d617979797669747269222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a2237373736303030222c2245787069726573223a313536333736323836312c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a227368626964222c2256616c7565223a2231343338222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a22363034383030222c2245787069726573223a313535363539313636312c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a227368627473222c2256616c7565223a22313535353938363836312e31333232333438222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a22363034383030222c2245787069726573223a313535363539313636312c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a2273657373696f6e6964222c2256616c7565223a22333936323134363036312533416a4179464a414e475154524c576e2533413230222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a223331353336303030222c2245787069726573223a313538373532323836312c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a22727572222c2256616c7565223a22415348222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a6e756c6c2c2245787069726573223a6e756c6c2c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a226967666c222c2256616c7565223a226d617979797669747269222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a223836343030222c2245787069726573223a313535363037333236342c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a2269735f737461727265645f656e61626c6564222c2256616c7565223a22796573222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a22333135333630303030222c2245787069726573223a313837313334373230302c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a2264735f757365725f6964222c2256616c7565223a2233393632313436303631222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a2237373736303030222c2245787069726573223a313536333736333230302c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d2c7b224e616d65223a2275726c67656e222c2256616c7565223a225c227b5c5c5c223132352e3136342e33312e35375c5c5c223a20373731337d3a3168496c4c6b3a746f4c6a5946517672743066675868354875556b4851615f6c54515c22222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a6e756c6c2c2245787069726573223a6e756c6c2c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a747275657d2c7b224e616d65223a2263737266746f6b656e222c2256616c7565223a226665666a5373743869556b33783257356e7a5146463757307a326d6576416b48222c22446f6d61696e223a222e696e7374616772616d2e636f6d222c2250617468223a225c2f222c224d61782d416765223a223331343439363030222c2245787069726573223a313538373433363830302c22536563757265223a747275652c2244697363617264223a66616c73652c22487474704f6e6c79223a66616c73657d5d, '2019-04-23 02:40:01', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1812;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
