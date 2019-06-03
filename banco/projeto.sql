SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `estados` (
  `estadoID` tinyint(3) UNSIGNED NOT NULL,
  `nome` char(20) NOT NULL,
  `sigla` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `estados`
--

INSERT INTO `estados` (`estadoID`, `nome`, `sigla`) VALUES
(1, 'Acre', 'AC'),
(2, 'Alagoas', 'AL'),
(3, 'Amapá', 'AP'),
(4, 'Amazonas', 'AM'),
(5, 'Bahia', 'BA'),
(6, 'Ceará', 'CE'),
(7, 'Distrito Federal', 'DF'),
(8, 'Espírito Santo', 'ES'),
(9, 'Goiás', 'GO'),
(10, 'Maranhão', 'MA'),
(11, 'Mato Grosso', 'MT'),
(12, 'Mato Grosso do Sul', 'MS'),
(13, 'Minas Gerais', 'MG'),
(14, 'Pará', 'PA'),
(15, 'Paraíba', 'PB'),
(16, 'Paraná', 'PR'),
(17, 'Pernambuco', 'PE'),
(19, 'Piauí', 'PI'),
(20, 'RG do Norte', 'RN'),
(21, 'RG do Sul', 'RS'),
(22, 'Rio de Janeiro', 'RJ'),
(24, 'Rondônia', 'RO'),
(25, 'Roraima', 'RA'),
(26, 'Santa Catarina', 'SC'),
(27, 'São Paulo', 'SP'),
(28, 'Santa Catarina', 'SC'),
(29, 'Sergipe', 'SE'),
(30, 'Tocantins', 'TO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `fornecedorID` int(8) NOT NULL,
  `nomefornecedor` varchar(50) DEFAULT NULL,
  `endereco` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `telefone` varchar(14) DEFAULT NULL,
  `estadoid` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fornecedores`
--

INSERT INTO `fornecedores` (`fornecedorID`, `nomefornecedor`, `endereco`, `cidade`, `telefone`, `estadoid`) VALUES
(1, 'Joe Mugger', 'Rua Ernesto de Paula Santos, 187', 'Recife', '949 568 7852', 17),
(2, 'Dining Suppliers', '5 Hometown Dr.', 'São Paulo', '565 123 1223', 27),
(3, 'Pacific Merchandise', '56 Parkway Plaza', 'Rio de Janeiro', '310 345 4565', 22),
(4, 'Quick Clothing', '4598 Main St', 'Porto Alegre', '858 555 1654', 21);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `produtoID` int(11) NOT NULL,
  `nomeproduto` varchar(50) DEFAULT NULL,
  `codigobarra` varchar(15) DEFAULT NULL,
  `precounitario` decimal(10,2) DEFAULT NULL,
  `estoque` mediumint(4) DEFAULT NULL,
  `fornecedorid` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`produtoID`, `nomeproduto`, `codigobarra`, `precounitario`, `estoque`, `fornecedorid`) VALUES
(4, 'Feijão', '56464', '3.50', 200, 3),
(5, 'Mamão', '656464', '5.00', 100, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `userID` int(8) NOT NULL,
  `nomecompleto` varchar(50) DEFAULT NULL,
  `endereco` varchar(50) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `numero` varchar(15) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `ddd` varchar(3) DEFAULT NULL,
  `telefone` varchar(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `usuario` varchar(10) DEFAULT NULL,
  `senha` varchar(10) DEFAULT NULL,
  `idestado` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`userID`, `nomecompleto`, `endereco`, `complemento`, `numero`, `cidade`, `cep`, `ddd`, `telefone`, `email`, `usuario`, `senha`, `idestado`) VALUES
(3, 'Salvador Melo', 'Qa 7', 'casa', '11', 'Sobradinho', '73752111', '061', '23423', 'salvadormelo@hotmail.com', 'salvador', 'melo', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`estadoID`);

--
-- Indexes for table `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`fornecedorID`),
  ADD KEY `fornecedores_estados_id` (`estadoid`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`produtoID`),
  ADD KEY `produtos_fornecedores_id` (`fornecedorid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `users_estados` (`idestado`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `estados`
--
ALTER TABLE `estados`
  MODIFY `estadoID` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `fornecedorID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `produtoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD CONSTRAINT `fornecedores_estados_id` FOREIGN KEY (`estadoid`) REFERENCES `estados` (`estadoID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_fornecedores_id` FOREIGN KEY (`fornecedorid`) REFERENCES `fornecedores` (`fornecedorID`);

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_estados` FOREIGN KEY (`idestado`) REFERENCES `estados` (`estadoID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
