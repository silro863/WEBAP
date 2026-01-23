-- Create messages table for trainer chat
CREATE TABLE IF NOT EXISTS `messages` (
  `idMessage` int(11) NOT NULL AUTO_INCREMENT,
  `idSender` int(11) NOT NULL,
  `idReceiver` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `isRead` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`idMessage`),
  FOREIGN KEY (`idSender`) REFERENCES `trainers`(`idTrainer`) ON DELETE CASCADE,
  FOREIGN KEY (`idReceiver`) REFERENCES `trainers`(`idTrainer`) ON DELETE CASCADE,
  INDEX (`idSender`),
  INDEX (`idReceiver`),
  INDEX (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
