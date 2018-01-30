-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Янв 30 2018 г., 19:58
-- Версия сервера: 5.5.53-log
-- Версия PHP: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `monsterdev`
--

-- --------------------------------------------------------

--
-- Структура таблицы `fight_rooms`
--

CREATE TABLE `fight_rooms` (
  `id` int(5) UNSIGNED NOT NULL,
  `session_id` varchar(40) NOT NULL,
  `user_1_id` int(11) NOT NULL,
  `user_2_id` int(11) NOT NULL,
  `status` int(5) UNSIGNED NOT NULL,
  `room_type` int(5) UNSIGNED NOT NULL,
  `round_number` int(5) UNSIGNED NOT NULL,
  `winner_id` int(5) UNSIGNED NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `closed_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `fight_rooms`
--

INSERT INTO `fight_rooms` (`id`, `session_id`, `user_1_id`, `user_2_id`, `status`, `room_type`, `round_number`, `winner_id`, `create_at`, `closed_at`) VALUES
(9, '1517329689_1_2', 1, 2, 2, 1, 0, 1, '2018-01-30 16:52:22', '0000-00-00 00:00:00'),
(10, '1517331173_1_2', 1, 2, 2, 1, 0, 2, '2018-01-30 16:56:48', '0000-00-00 00:00:00'),
(11, '1517331439_1_2', 1, 2, 0, 1, 0, 0, '2018-01-30 16:57:19', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `fight_sessions`
--

CREATE TABLE `fight_sessions` (
  `id` int(5) UNSIGNED NOT NULL,
  `room_type` varchar(20) NOT NULL,
  `session_id` varchar(40) NOT NULL,
  `session_data` longtext NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `fight_sessions`
--

INSERT INTO `fight_sessions` (`id`, `room_type`, `session_id`, `session_data`, `status`) VALUES
(22, 'classic', '1517329689_1_2', '{\"users\":{\"1\":{\"62818\":{\"fight_data\":{\"monster_id\":62818,\"user_id\":\"1\",\"health\":-9.5,\"power\":10.5,\"speed\":\"8.00\",\"skills\":{\"119\":{\"damage\":22.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"167\":{\"damage\":29.5,\"healing\":0,\"healingpct\":0,\"duration\":6.5,\"cooldown\":\"1\",\"type\":\"5\"},\"411\":{\"damage\":14.5,\"healing\":0,\"healingpct\":0,\"duration\":6.5,\"cooldown\":null,\"type\":\"8\"},\"165\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":\"4\",\"type\":\"5\"},\"163\":{\"damage\":29.5,\"healing\":0,\"healingpct\":0,\"duration\":4.5,\"cooldown\":null,\"type\":\"5\"}}}},\"7560\":{\"fight_data\":{\"monster_id\":7560,\"user_id\":\"1\",\"health\":-15.5,\"power\":9.5,\"speed\":\"9.00\",\"skills\":{\"119\":{\"damage\":22.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"159\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":\"4\",\"type\":\"8\"},\"360\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"312\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":\"4\",\"type\":\"1\"},\"163\":{\"damage\":29.5,\"healing\":0,\"healingpct\":0,\"duration\":4.5,\"cooldown\":null,\"type\":\"5\"}}}},\"62178\":{\"fight_data\":{\"monster_id\":62178,\"user_id\":\"1\",\"health\":9,\"power\":9,\"speed\":\"9.50\",\"skills\":{\"119\":{\"damage\":22.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"159\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":\"4\",\"type\":\"8\"},\"360\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"312\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":\"4\",\"type\":\"1\"},\"163\":{\"damage\":29.5,\"healing\":0,\"healingpct\":0,\"duration\":4.5,\"cooldown\":null,\"type\":\"5\"}}}}},\"2\":{\"61369\":{\"fight_data\":{\"monster_id\":61369,\"user_id\":\"2\",\"health\":-2.5,\"power\":10,\"speed\":\"8.00\",\"skills\":{\"118\":{\"damage\":22.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"9\"},\"123\":{\"damage\":0,\"healing\":32.5,\"healingpct\":0,\"duration\":0,\"cooldown\":\"3\",\"type\":\"9\"},\"233\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":\"1\",\"type\":\"9\"},\"228\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"230\":{\"damage\":0,\"healing\":26.5,\"healingpct\":0,\"duration\":11.5,\"cooldown\":\"3\",\"type\":\"9\"},\"232\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":7.5,\"cooldown\":null,\"type\":\"5\"}}}},\"14421\":{\"fight_data\":{\"monster_id\":14421,\"user_id\":\"2\",\"health\":-7.5,\"power\":10,\"speed\":\"8.50\",\"skills\":{\"367\":{\"damage\":24.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"364\":{\"damage\":17.5,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":null,\"type\":\"8\"},\"253\":{\"damage\":27.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"165\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":\"4\",\"type\":\"5\"},\"159\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":\"4\",\"type\":\"8\"}}}},\"61141\":{\"fight_data\":{\"monster_id\":61141,\"user_id\":\"2\",\"health\":-7.5,\"power\":10,\"speed\":\"8.50\",\"skills\":{\"367\":{\"damage\":24.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"364\":{\"damage\":17.5,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":null,\"type\":\"8\"},\"159\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":\"4\",\"type\":\"8\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"165\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":\"4\",\"type\":\"5\"},\"253\":{\"damage\":27.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"}}}}}},\"statuses\":{\"users\":[\"1\",\"2\"],\"user_1_active_monster\":62178,\"user_2_active_monster\":61141,\"round\":12,\"round_action\":\"middle\",\"message\":\"User 1 winner!\",\"over_time\":[],\"die\":{\"1\":{\"62818\":62818,\"7560\":7560},\"2\":{\"61369\":61369,\"14421\":14421,\"61141\":61141}},\"first_move_user\":\"1\"}}', 2),
(23, 'classic', '1517331173_1_2', '{\"users\":{\"1\":{\"62818\":{\"fight_data\":{\"monster_id\":62818,\"user_id\":\"1\",\"health\":-22.5,\"power\":10.5,\"speed\":\"8.00\",\"skills\":{\"119\":{\"damage\":22.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"167\":{\"damage\":29.5,\"healing\":0,\"healingpct\":0,\"duration\":6.5,\"cooldown\":\"1\",\"type\":\"5\"},\"411\":{\"damage\":14.5,\"healing\":0,\"healingpct\":0,\"duration\":6.5,\"cooldown\":null,\"type\":\"8\"},\"165\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":\"4\",\"type\":\"5\"},\"163\":{\"damage\":29.5,\"healing\":0,\"healingpct\":0,\"duration\":4.5,\"cooldown\":null,\"type\":\"5\"}}}},\"7560\":{\"fight_data\":{\"monster_id\":7560,\"user_id\":\"1\",\"health\":-17.5,\"power\":9.5,\"speed\":\"9.00\",\"skills\":{\"119\":{\"damage\":22.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"159\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":\"4\",\"type\":\"8\"},\"360\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"312\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":\"4\",\"type\":\"1\"},\"163\":{\"damage\":29.5,\"healing\":0,\"healingpct\":0,\"duration\":4.5,\"cooldown\":null,\"type\":\"5\"}}}},\"62178\":{\"fight_data\":{\"monster_id\":62178,\"user_id\":\"1\",\"health\":0,\"power\":9,\"speed\":\"9.50\",\"skills\":{\"119\":{\"damage\":22.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"159\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":\"4\",\"type\":\"8\"},\"360\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"312\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":\"4\",\"type\":\"1\"},\"163\":{\"damage\":29.5,\"healing\":0,\"healingpct\":0,\"duration\":4.5,\"cooldown\":null,\"type\":\"5\"}}}}},\"2\":{\"61369\":{\"fight_data\":{\"monster_id\":61369,\"user_id\":\"2\",\"health\":-2.5,\"power\":10,\"speed\":\"8.00\",\"skills\":{\"118\":{\"damage\":22.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"9\"},\"123\":{\"damage\":0,\"healing\":32.5,\"healingpct\":0,\"duration\":0,\"cooldown\":\"3\",\"type\":\"9\"},\"233\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":\"1\",\"type\":\"9\"},\"228\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"230\":{\"damage\":0,\"healing\":26.5,\"healingpct\":0,\"duration\":11.5,\"cooldown\":\"3\",\"type\":\"9\"},\"232\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":7.5,\"cooldown\":null,\"type\":\"5\"}}}},\"14421\":{\"fight_data\":{\"monster_id\":14421,\"user_id\":\"2\",\"health\":15,\"power\":10,\"speed\":\"8.50\",\"skills\":{\"367\":{\"damage\":24.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"364\":{\"damage\":17.5,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":null,\"type\":\"8\"},\"253\":{\"damage\":27.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"165\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":\"4\",\"type\":\"5\"},\"159\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":\"4\",\"type\":\"8\"}}}},\"61141\":{\"fight_data\":{\"monster_id\":61141,\"user_id\":\"2\",\"health\":-7.5,\"power\":10,\"speed\":\"8.50\",\"skills\":{\"367\":{\"damage\":24.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"364\":{\"damage\":17.5,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":null,\"type\":\"8\"},\"159\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":\"4\",\"type\":\"8\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"165\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":\"4\",\"type\":\"5\"},\"253\":{\"damage\":27.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"}}}}}},\"statuses\":{\"users\":[\"1\",\"2\"],\"user_1_active_monster\":62178,\"user_2_active_monster\":14421,\"round\":12,\"round_action\":\"begin\",\"message\":\"User 2 winner!\",\"over_time\":[],\"die\":{\"1\":{\"62818\":62818,\"7560\":7560,\"62178\":62178},\"2\":{\"61141\":\"61141\",\"61369\":61369}},\"first_move_user\":\"1\"}}', 2),
(24, 'classic', '1517331439_1_2', '{\"users\":{\"1\":{\"62818\":{\"fight_data\":{\"monster_id\":62818,\"user_id\":\"1\",\"health\":82.5,\"power\":10.5,\"speed\":\"8.00\",\"skills\":{\"119\":{\"damage\":22.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"167\":{\"damage\":29.5,\"healing\":0,\"healingpct\":0,\"duration\":6.5,\"cooldown\":\"1\",\"type\":\"5\"},\"411\":{\"damage\":14.5,\"healing\":0,\"healingpct\":0,\"duration\":6.5,\"cooldown\":null,\"type\":\"8\"},\"165\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":\"4\",\"type\":\"5\"},\"163\":{\"damage\":29.5,\"healing\":0,\"healingpct\":0,\"duration\":4.5,\"cooldown\":null,\"type\":\"5\"}}}},\"7560\":{\"fight_data\":{\"monster_id\":7560,\"user_id\":\"1\",\"health\":82.5,\"power\":9.5,\"speed\":\"9.00\",\"skills\":{\"119\":{\"damage\":22.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"159\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":\"4\",\"type\":\"8\"},\"360\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"312\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":\"4\",\"type\":\"1\"},\"163\":{\"damage\":29.5,\"healing\":0,\"healingpct\":0,\"duration\":4.5,\"cooldown\":null,\"type\":\"5\"}}}},\"62178\":{\"fight_data\":{\"monster_id\":62178,\"user_id\":\"1\",\"health\":82.5,\"power\":9,\"speed\":\"9.50\",\"skills\":{\"119\":{\"damage\":22.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"159\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":\"4\",\"type\":\"8\"},\"360\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"312\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":\"4\",\"type\":\"1\"},\"163\":{\"damage\":29.5,\"healing\":0,\"healingpct\":0,\"duration\":4.5,\"cooldown\":null,\"type\":\"5\"}}}}},\"2\":{\"61369\":{\"fight_data\":{\"monster_id\":61369,\"user_id\":\"2\",\"health\":87.5,\"power\":10,\"speed\":\"8.00\",\"skills\":{\"118\":{\"damage\":22.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"9\"},\"123\":{\"damage\":0,\"healing\":32.5,\"healingpct\":0,\"duration\":0,\"cooldown\":\"3\",\"type\":\"9\"},\"233\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":\"1\",\"type\":\"9\"},\"228\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"230\":{\"damage\":0,\"healing\":26.5,\"healingpct\":0,\"duration\":11.5,\"cooldown\":\"3\",\"type\":\"9\"},\"232\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":7.5,\"cooldown\":null,\"type\":\"5\"}}}},\"14421\":{\"fight_data\":{\"monster_id\":14421,\"user_id\":\"2\",\"health\":82.5,\"power\":10,\"speed\":\"8.50\",\"skills\":{\"367\":{\"damage\":24.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"364\":{\"damage\":17.5,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":null,\"type\":\"8\"},\"253\":{\"damage\":27.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"165\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":\"4\",\"type\":\"5\"},\"159\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":\"4\",\"type\":\"8\"}}}},\"61141\":{\"fight_data\":{\"monster_id\":61141,\"user_id\":\"2\",\"health\":82.5,\"power\":10,\"speed\":\"8.50\",\"skills\":{\"367\":{\"damage\":24.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"},\"364\":{\"damage\":17.5,\"healing\":0,\"healingpct\":0,\"duration\":3.5,\"cooldown\":null,\"type\":\"8\"},\"159\":{\"damage\":32.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":\"4\",\"type\":\"8\"},\"162\":{\"damage\":12.5,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":null,\"type\":\"5\"},\"165\":{\"damage\":0,\"healing\":0,\"healingpct\":0,\"duration\":5.5,\"cooldown\":\"4\",\"type\":\"5\"},\"253\":{\"damage\":27.5,\"healing\":0,\"healingpct\":0,\"duration\":0,\"cooldown\":null,\"type\":\"5\"}}}}}},\"statuses\":{\"users\":[\"1\",\"2\"],\"user_1_active_monster\":62818,\"user_2_active_monster\":61369,\"round\":1,\"round_action\":\"begin\",\"message\":\"First round\",\"over_time\":[],\"die\":{\"1\":[],\"2\":[]},\"first_move_user\":\"1\"}}', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `fight_rooms`
--
ALTER TABLE `fight_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fight_sessions`
--
ALTER TABLE `fight_sessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `fight_rooms`
--
ALTER TABLE `fight_rooms`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `fight_sessions`
--
ALTER TABLE `fight_sessions`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
