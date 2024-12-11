-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-12-11 16:25
-- 서버 버전: 10.4.32-MariaDB
-- PHP 버전: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `community_board`
--
CREATE DATABASE IF NOT EXISTS `community_board` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `community_board`;

-- --------------------------------------------------------

--
-- 테이블 구조 `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `content`, `created_at`) VALUES
(1, 6, 4, '그러니까 어캐 달성한거임ㄷㄷ', '2024-12-08 09:27:52'),
(2, 9, 4, '기분이 좋다\r\n이제 다시 세워야겠네', '2024-12-08 09:32:29'),
(3, 9, 1, '실수로 삭제한 것 같습니다.\r\n빠른시일내에 고쳐서 다시 올려드리겠습니다.\r\n불편을 드려 죄송합니다.', '2024-12-08 09:33:19');

-- --------------------------------------------------------

--
-- 테이블 구조 `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_announcement` tinyint(1) DEFAULT 0,
  `score` int(11) NOT NULL,
  `game_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `content`, `user_id`, `created_at`, `updated_at`, `is_announcement`, `score`, `game_name`) VALUES
(1, '제일 높은 기록이다', '제일 높은 기록을 달성했다.\r\n누가 뛰어넘을 것인가', 2, '2024-12-08 09:19:20', '2024-12-08 09:19:20', 0, 3068, '2048'),
(2, '이동횟수 제일 적은거', '그래도 운이 좋아서\r\n많이 안움직인거 같다', 3, '2024-12-08 09:22:36', '2024-12-08 09:22:36', 0, 70, 'maze'),
(3, '3000점 넘는건', '어떻게 달성한거지\r\n가능한건가', 4, '2024-12-08 09:25:01', '2024-12-08 09:25:01', 0, 1376, '2048'),
(4, '나중에 어떻게든 최단기록 세워야지', '운이 좋아지겠지 점점', 4, '2024-12-08 09:26:08', '2024-12-08 09:28:41', 0, 102, 'maze'),
(5, '언젠가는', '내가 꼭 3000점 달성한다', 4, '2024-12-08 09:26:39', '2024-12-08 09:26:39', 0, 1376, '2048'),
(6, '공략을 궁금해하는것같아서...', '이 게임 공략따위는 없음\r\n그냥 막 누르니까 넘은거임ㅋㅋ', 2, '2024-12-08 09:27:20', '2024-12-08 09:27:20', 0, 3068, '2048'),
(7, '게임을 잘 즐기시고 계신거 같아 기쁩니다', '앞으로도 많은 이용 바랍니다.', 1, '2024-12-08 09:29:39', '2024-12-08 09:29:39', 1, 0, '공지'),
(8, '추후 예정된 사항', '추후 많은 게임들이 추가될 예정입니다.\r\n기대해주시면 감사하겠습니다.', 1, '2024-12-08 09:30:07', '2024-12-08 09:30:07', 1, 0, '공지'),
(9, '내 최고기록', '내 최고기록 돌려줘요\r\n왜 사라졌어', 2, '2024-12-08 09:31:58', '2024-12-08 09:31:58', 0, 936, '2048');

-- --------------------------------------------------------

--
-- 테이블 구조 `post_likes`
--

CREATE TABLE `post_likes` (
  `like_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `full_name`, `email`, `created_at`) VALUES
(1, 'admin', '$2y$10$SWsRi0jO8dhlk1hMVSzXHO4nHd6k4FxcXNuVHx9OuDF7rqZer2FKq', '관리자', 'admin@chungwoon.ac.kr', '2024-12-08 09:15:37'),
(2, 'gildong', '$2y$10$RhaAjCPZ6hr.upzuzurZHeoHlEzRi0/rJwOdzppbdSi79squawQuS', '홍길동', 'gildong@chungwoon.ac.kr', '2024-12-08 09:15:57'),
(3, 'churesu', '$2y$10$O/pZ7aAjlqivRHrVG7gU5OzG2Hjg0rXxhvaPcxq9oaUovdEa6iV/i', '철수', 'churesu@chungwoon.ac.kr', '2024-12-08 09:16:52'),
(4, 'younghee', '$2y$10$RwmzcVhva9EZFxhndfyi0uxqC9CxZMBLiH.YJUoTYwllG5hZZZvyO', '영희', 'younghee@chungwoon.ac.kr', '2024-12-08 09:17:28');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 테이블의 인덱스 `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 테이블의 인덱스 `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`like_id`),
  ADD UNIQUE KEY `post_id` (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 테이블의 인덱스 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 테이블의 AUTO_INCREMENT `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
--
-- 데이터베이스: `game_scores`
--
CREATE DATABASE IF NOT EXISTS `game_scores` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `game_scores`;

-- --------------------------------------------------------

--
-- 테이블 구조 `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `game_name` varchar(255) NOT NULL,
  `player_name` varchar(255) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `scores`
--

INSERT INTO `scores` (`id`, `game_name`, `player_name`, `score`) VALUES
(2, 'maze', 'gildong', 74),
(3, 'number_guess', 'gildong', 7),
(4, '2048', 'churesu', 1588),
(5, '2048', 'churesu', 720),
(6, '2048', 'churesu', 1432),
(7, 'maze', 'churesu', 82),
(8, 'maze', 'churesu', 70),
(9, 'number_guess', 'churesu', 8),
(10, 'number_guess', 'churesu', 9),
(11, '2048', 'younghee', 984),
(12, '2048', 'younghee', 1376),
(13, 'maze', 'younghee', 70),
(14, 'maze', 'younghee', 102),
(15, '2048', 'gildong', 936);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- 데이터베이스: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- 테이블의 덤프 데이터 `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"community_board\",\"table\":\"comments\"},{\"db\":\"community_board\",\"table\":\"posts\"},{\"db\":\"game_scores\",\"table\":\"scores\"},{\"db\":\"community_board\",\"table\":\"users\"},{\"db\":\"community_board\",\"table\":\"post_likes\"},{\"db\":\"game_scores\",\"table\":\"highscores\"},{\"db\":\"game_scores\",\"table\":\"maze_games\"},{\"db\":\"game_scores_db\",\"table\":\"scores\"},{\"db\":\"game_scores_db\",\"table\":\"game_scores\"}]');

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- 테이블의 덤프 데이터 `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2024-12-11 15:21:12', '{\"Console\\/Mode\":\"collapse\",\"lang\":\"ko\"}');

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- 테이블 구조 `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- 테이블의 인덱스 `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- 테이블의 인덱스 `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- 테이블의 인덱스 `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- 테이블의 인덱스 `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- 테이블의 인덱스 `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- 테이블의 인덱스 `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- 테이블의 인덱스 `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- 테이블의 인덱스 `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- 테이블의 인덱스 `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- 테이블의 인덱스 `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- 테이블의 인덱스 `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- 테이블의 인덱스 `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- 테이블의 인덱스 `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- 테이블의 인덱스 `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- 테이블의 인덱스 `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- 테이블의 인덱스 `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- 테이블의 인덱스 `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 데이터베이스: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
