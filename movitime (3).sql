-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Jan-2024 às 19:45
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `movitime`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorys`
--

CREATE TABLE `categorys` (
  `idCategory` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categorys`
--

INSERT INTO `categorys` (`idCategory`, `name`) VALUES
(1, 'Ação'),
(2, 'Aventura'),
(3, 'Ação e aventura'),
(4, 'Drama'),
(5, 'Comédia romântica'),
(6, 'Ficção científica'),
(7, 'Terror'),
(8, 'Comédia'),
(9, 'Românce'),
(10, 'Comédia'),
(11, 'Românce');

-- --------------------------------------------------------

--
-- Estrutura da tabela `coments`
--

CREATE TABLE `coments` (
  `idComent` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL,
  `coment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `loads`
--

CREATE TABLE `loads` (
  `idLoads` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `loads`
--

INSERT INTO `loads` (`idLoads`, `name`) VALUES
(1, 'admin'),
(2, 'taster'),
(5, 'user');

-- --------------------------------------------------------

--
-- Estrutura da tabela `moviecategory`
--

CREATE TABLE `moviecategory` (
  `idMovieCategory` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL,
  `idCategory` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `moviecategory`
--

INSERT INTO `moviecategory` (`idMovieCategory`, `idMovie`, `idCategory`) VALUES
(8, 9, 7),
(9, 10, 1),
(10, 11, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `movies`
--

CREATE TABLE `movies` (
  `idMovie` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `duration` int(11) NOT NULL,
  `releaseYear` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `imgMovie` varchar(255) NOT NULL,
  `trail` varchar(255) NOT NULL,
  `approval` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `movies`
--

INSERT INTO `movies` (`idMovie`, `name`, `duration`, `releaseYear`, `description`, `imgMovie`, `trail`, `approval`) VALUES
(9, 'Nós', 91, '2019', 'Adelaide e Gabe levam a família para passar um fim de semana na praia e descansar. Eles começam a aproveitar o ensolarado local, mas a chegada de um grupo misterioso muda tudo e a família se torna refém de seres com aparências iguais às suas.', '656521a4017a5_images.jpg', 'https://www.youtube.com/watch?v=1ZIbLgH36Nk&ab_channel=UniversalPicturesPortugal', 1),
(10, 'Free Guy: Herói Improvável', 85, '2021', 'Um caixa de banco preso a uma entediante rotina tem sua vida virada de cabeça para baixo quando descobre que é um personagem em um jogo interativo. Agora ele precisa aceitar sua realidade e lidar com o fato de que é o único que pode salvar o mundo.', '65652215b59db_FreeGuy_CATCHPHRASE_INTL_CHARACTER_BANNER_RYAN_PORTUGAL.jpg', 'https://www.youtube.com/watch?v=b7xo15T3Ef0&ab_channel=20thCenturyStudiosPortugal', 1),
(11, 'O Livro de Eli', 88, '2010', 'Trinta anos depois da guerra ter dizimado o mundo, um guerreiro solitário chamado Eli caminha por horizontes arruinados dando esperança para os que restaram. Apenas um outro homem compreende o poder de um livro que Eli carrega e está determinado a se apoderar dele. Apesar de Eli preferir a paz, ele arriscará a sua vida para proteger a sua carga preciosa, pois precisa cumprir o seu destino de ajudar a restaurar a humanidade.', '6567169c1f15c_images (1).jpg', 'https://www.youtube.com/watch?v=t3qJj_ljctE&ab_channel=SonyPicturesBrasil', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nameUser` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `imgProfile` varchar(256) NOT NULL,
  `idLoads` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`idUser`, `username`, `password`, `nameUser`, `email`, `imgProfile`, `idLoads`) VALUES
(7, 'jonyG', '$2y$10$.Rv2G1AIK1yEKDWMGC5P5OQEAH/rw34Ty0edRiI/DU4fvSB1PzMum', 'João Pedro', 'jonyg@gmail.com', 'uploads/656231818fdfd_joao.jpg', 2),
(9, 'pedro.moura', '$2y$10$4MZLuzZLCCPN8VxPhEPWOuhUWheo/z7kuzzwvig8DB/nmGPcVD6oq', 'Pedro Miguel Álvares de Moura', 'pedromoura@gmail.com', 'uploads/658887345fc6b_305923247_474594221346504_1536418863465470168_n-removebg-preview.png', 1),
(10, 'tomas', '$2y$10$df4v3oa5W1LJVAorofot9.p2l2uorGEx0El2feAHikhCTkfzf8K1C', 'tomas', 'tomas@gmail.com', '', 5),
(11, 'teste', '$2y$10$NniGDXp7Uy3NOjM8SwihCuoSRlS34t3W/IbuppJQf8kPxZm.Ab6H.', 'teste', 'teste@gmail.com', '', 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categorys`
--
ALTER TABLE `categorys`
  ADD PRIMARY KEY (`idCategory`);

--
-- Índices para tabela `coments`
--
ALTER TABLE `coments`
  ADD PRIMARY KEY (`idComent`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idMovie` (`idMovie`);

--
-- Índices para tabela `loads`
--
ALTER TABLE `loads`
  ADD PRIMARY KEY (`idLoads`);

--
-- Índices para tabela `moviecategory`
--
ALTER TABLE `moviecategory`
  ADD PRIMARY KEY (`idMovieCategory`),
  ADD KEY `idCategory` (`idCategory`),
  ADD KEY `moviecategory_ibfk_1` (`idMovie`);

--
-- Índices para tabela `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`idMovie`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`),
  ADD KEY `fk_users_idLoads` (`idLoads`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorys`
--
ALTER TABLE `categorys`
  MODIFY `idCategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `loads`
--
ALTER TABLE `loads`
  MODIFY `idLoads` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `moviecategory`
--
ALTER TABLE `moviecategory`
  MODIFY `idMovieCategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `movies`
--
ALTER TABLE `movies`
  MODIFY `idMovie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `coments`
--
ALTER TABLE `coments`
  ADD CONSTRAINT `coments_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`),
  ADD CONSTRAINT `coments_ibfk_2` FOREIGN KEY (`idMovie`) REFERENCES `movies` (`idMovie`);

--
-- Limitadores para a tabela `moviecategory`
--
ALTER TABLE `moviecategory`
  ADD CONSTRAINT `moviecategory_ibfk_1` FOREIGN KEY (`idMovie`) REFERENCES `movies` (`idMovie`),
  ADD CONSTRAINT `moviecategory_ibfk_2` FOREIGN KEY (`idCategory`) REFERENCES `categorys` (`idCategory`);

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_idLoads` FOREIGN KEY (`idLoads`) REFERENCES `loads` (`idLoads`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
