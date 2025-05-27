-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27-Maio-2025 às 22:32
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `agenda_facil`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(7) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `data_consulta` date NOT NULL,
  `hora_consulta` time NOT NULL,
  `observacao` varchar(200) NOT NULL,
  `data_criacao` datetime NOT NULL,
  `data_atualizacao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `medico_id`, `paciente_id`, `data_consulta`, `hora_consulta`, `observacao`, `data_criacao`, `data_atualizacao`) VALUES
(2, 2, 2, '2025-05-29', '16:00:00', 'Outra observação', '2025-05-27 00:00:00', '2025-05-27 00:00:00'),
(3, 2, 4, '2025-05-30', '11:00:00', 'observação do paciente', '2025-05-27 00:00:00', '2025-05-27 00:00:00'),
(4, 4, 5, '2025-05-28', '14:00:00', 'Verificando', '2025-05-27 00:00:00', '2025-05-27 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `api_tokens`
--

CREATE TABLE `api_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `api_tokens`
--

INSERT INTO `api_tokens` (`id`, `token`) VALUES
(1, 'rafael123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicos`
--

CREATE TABLE `medicos` (
  `id` int(5) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `crm` varchar(20) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `data_criacao` date NOT NULL,
  `data_atualizacao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `medicos`
--

INSERT INTO `medicos` (`id`, `nome`, `email`, `crm`, `senha`, `data_criacao`, `data_atualizacao`) VALUES
(2, 'Rafael Montagnini', 'rafael@gmail.com', 'a1235', '$2y$10$RtrFlrUhxrOoBymezx2uxunWZHq8BRbZf6rnPXPFM5zgrL9Z70Glq', '2025-05-26', '2025-05-26'),
(3, 'Felipe Silva', 'felipe@gmail.com', '1234567', '$2y$10$bKg1dQEzWgDpiSC37YjvAOSkjRlRd.odRiO3D0viKeO.hIaOOnLTy', '2025-05-27', '2025-05-27'),
(4, 'Matheus Silva', 'matheus@gmail.com', '123456', '$2y$10$//0pQkC2LgaJXVSf6.VHzuJwBCCv.TboWYYswxNrUKACOZLczwKCi', '2025-05-27', '2025-05-27'),
(5, 'Vitor Silva', 'vitor@gmail.com', '12345', '$2y$10$bwwGbaodknJA1Xx82yNRGeSkSmarpsLdVlBZv29jbWDcR54cLlNhO', '2025-05-27', '2025-05-27'),
(6, 'Italo', 'italo@gmail.com', '12345', '$2y$10$q5/gLKLj5TZIgzTddJ0MUeD9ChI2vwLIFMn8RIt0kqSqIqAgsQuQy', '2025-05-27', '2025-05-27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(5) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `data_nascimento` date NOT NULL,
  `sexo` varchar(15) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `data_criacao` date NOT NULL,
  `data_atualizacao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pacientes`
--

INSERT INTO `pacientes` (`id`, `nome`, `cpf`, `email`, `celular`, `data_nascimento`, `sexo`, `medico_id`, `data_criacao`, `data_atualizacao`) VALUES
(2, 'RAFAEL MONTAGNINI', '422.222.222-22', 'rafael@gmail.com.br', '(16) 99392-2821', '1995-11-15', 'MASCULINO', 2, '2025-05-27', '2025-05-27'),
(4, 'MATHEUS SILVA', '445.874.598-55', 'matheus@gmail.com', '(16) 98745-1245', '1992-10-16', 'MASCULINO', 2, '2025-05-27', '2025-05-27'),
(5, 'WESLEY SILVA', '478.545.425-45', 'wesley@gmail.com', '(99) 99999-9999', '1984-05-08', 'MASCULINO', 4, '2025-05-27', '2025-05-27');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `api_tokens`
--
ALTER TABLE `api_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `api_tokens`
--
ALTER TABLE `api_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
