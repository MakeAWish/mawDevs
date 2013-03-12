SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `makeawish`
--
USE `makeawish`;

-- --------------------------------------------------------

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'sport'),
(2, 'culture'),
(3, 'multimedia'),
(4, 'aucune');

--
-- Contenu de la table `colors`
--

INSERT INTO `colors` (`id`, `name`) VALUES
(2, 'black'),
(3, 'blue'),
(4, 'brown'),
(5, 'green'),
(6, 'lightblue'),
(7, 'lightgreen'),
(8, 'lightpink'),
(9, 'pink'),
(10, 'purple'),
(11, 'red');

-- --------------------------------------------------------

--
-- Contenu de la table `users`
--


INSERT INTO `users` (`id`, `username`, `surname`, `email`, `password`, `idcolor`, `salt`, `admin`) VALUES
(1, 'admin', 'admin', 'admin@domain.com', 'bfbb9d051864136a8fd2bb3032b874d1f5756c4d7cb8a9bfe7a13358ca1d04d58cb0473bd7969ae279eb0880f1a432251c732d7b10cdab4ce81fa5bc4fdcd0b0', 1, '48cb6c49b8dd517f75b1402ae332f02a513e3419646e7a8dbe4ade5350ba00260618ea9368097325860f7356c5f7def0c987fac0188fa303ddb57f37b8aef5ee', 1);

-- --------------------------------------------------------

--
-- Contenu de la table `wishlists`
--
INSERT INTO `wishlists` (`iduser`) VALUES
(1);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
