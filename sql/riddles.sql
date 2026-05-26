CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    answer VARCHAR(100) NOT NULL,
    hint VARCHAR(255),
    roomId INT NOT NULL
);

INSERT INTO questions (question, answer, hint, roomId)
VALUES

-- Kamer 1: Gevangeniscel
('Welke code opent de celdeur?', '1945', 'De cijfers staan gekrast onder het bed.', 1),
('Hoeveel tralies zitten voor het raam?', '8', 'Tel ze goed.', 1),
('Welke kleur heeft de sleutel van de bewaker?', 'Goud', 'Kijk in de jaszak.', 1),

-- Kamer 2: Bewakersruimte
('Wat is de achternaam van de directeur?', 'Jansen', 'Lees het dossier op het bureau.', 2),
('Welke vorm staat op de alarmknop?', 'Cirkel', 'Kijk naast de monitor.', 2),
('Hoe laat begint de nachtdienst?', '2300', 'Het rooster hangt aan de muur.', 2);
