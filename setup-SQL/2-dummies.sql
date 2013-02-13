SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `makeawish`
--

-- --------------------------------------------------------

--
-- Contenu de la table `colors`
--

INSERT INTO `colors` (`name`) VALUES
('black'),
('blue'),
('brown'),
('green'),
('lightblue'),
('lightgreen'),
('lightpink'),
('pink'),
('purple'),
('red');

-- --------------------------------------------------------

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`name`, `surname`, `email`, `password`, `idcolor`, `salt`) VALUES
('lastname1', 'firstname1', 'email1@domain.com', '', 1, ''),
('lastname2', 'firstname2', 'email2@domain.com', '', 2, '');

-- --------------------------------------------------------

--
-- Contenu de la table `wishlists`
--
INSERT INTO `wishlists` (`iduser`) VALUES
(1),
(2);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
