-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: mai 14, 2019 la 10:34 AM
-- Versiune server: 10.1.37-MariaDB
-- Versiune PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `loginsystemtut`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `projects`
--

CREATE TABLE `projects` (
  `idProiect` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `deadline` date NOT NULL,
  `status` varchar(15) NOT NULL,
  `descriere` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `subtasks`
--

CREATE TABLE `subtasks` (
  `idSubtask` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `descriere` text NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `tasks`
--

CREATE TABLE `tasks` (
  `idTask` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `deadline` date NOT NULL,
  `descriere` text NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `tasks`
--

INSERT INTO `tasks` (`idTask`, `name`, `deadline`, `descriere`, `status`) VALUES
(12, 'lalala', '2019-05-11', 'from shaormerie', 'Done'),
(13, 'lalala', '2019-05-12', 'asdadad', 'Undone'),
(14, 'ionel', '2019-05-09', 'from shaormerie', 'Undone');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `task_subtask_leg`
--

CREATE TABLE `task_subtask_leg` (
  `idLeg` int(10) NOT NULL,
  `idTask` int(10) NOT NULL,
  `idSubtask` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL,
  `uidUsers` tinytext NOT NULL,
  `emailUsers` tinytext NOT NULL,
  `pwdUsers` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`idUsers`, `uidUsers`, `emailUsers`, `pwdUsers`) VALUES
(1, 'george99cool', 'iuliangeorgepetre@gmail.com', '$2y$10$9vOSq0Hmu5BbMEtFLbxqo.4x2YEyF48KlYFLgo06YOF/IgraXHiDC');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `user_task_leg`
--

CREATE TABLE `user_task_leg` (
  `idLeg` int(11) NOT NULL,
  `idUsers` int(10) NOT NULL,
  `idTask` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `user_task_leg`
--

INSERT INTO `user_task_leg` (`idLeg`, `idUsers`, `idTask`) VALUES
(1, 0, 13),
(2, 1, 14);

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`idProiect`);

--
-- Indexuri pentru tabele `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwdResetId`);

--
-- Indexuri pentru tabele `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`idSubtask`);

--
-- Indexuri pentru tabele `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`idTask`);

--
-- Indexuri pentru tabele `task_subtask_leg`
--
ALTER TABLE `task_subtask_leg`
  ADD PRIMARY KEY (`idLeg`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- Indexuri pentru tabele `user_task_leg`
--
ALTER TABLE `user_task_leg`
  ADD PRIMARY KEY (`idLeg`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `projects`
--
ALTER TABLE `projects`
  MODIFY `idProiect` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `idSubtask` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `tasks`
--
ALTER TABLE `tasks`
  MODIFY `idTask` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pentru tabele `task_subtask_leg`
--
ALTER TABLE `task_subtask_leg`
  MODIFY `idLeg` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pentru tabele `user_task_leg`
--
ALTER TABLE `user_task_leg`
  MODIFY `idLeg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
