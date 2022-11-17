----- ENTITIES

CREATE TABLE USERS (
    IdUser      INT PRIMARY KEY AUTO_INCREMENT,
    FirstName   VARCHAR(255),
    LastName    VARCHAR(255),
    Email       VARCHAR(511),
    HashedPass  VARCHAR(64),
    IdBadge     INT,

    FOREIGN KEY (IdBadge) REFERENCES BADGES(IdBadge)
);

CREATE TABLE EXERCICES (
    IdExercice      INT PRIMARY KEY AUTO_INCREMENT,
    NameExercice    VARCHAR(255),
    Abstract        VARCHAR(1000)
);

CREATE TABLE BADGES (
    IdBadge     INT PRIMARY KEY AUTO_INCREMENT,
    NameBadge   VARCHAR(255),
    ColorBadge  VARCHAR(8)
);

CREATE TABLE INFOS (
    IdInfo      INT PRIMARY KEY AUTO_INCREMENT,
    NameInfo    VARCHAR(255),
    Abstract    VARCHAR(1000)
);

----- RELATIONS

-- USER EXERCICE RELATION

CREATE TABLE SOLVE (
    IdUser          INT NOT NULL,
    IdExercice      INT NOT NULL,
    ValueSolution   VARCHAR(255),
    DateBegin       DATETIME,
    DateEnd         DATETIME,
    LanguageS       VARCHAR(255) NOT NULL,

    PRIMARY KEY (IdUser, IdExercice),
    FOREIGN KEY (IdUser) REFERENCES USERS(IdUser),
    FOREIGN KEY (IdExercice) REFERENCES EXERCICES(IdExercice)
);

-- USER BADGE RELATION

CREATE TABLE OWN (
    IdUser  INT NOT NULL,
    IdBadge INT NOT NULL,

    PRIMARY KEY (IdUser, IdBadge),
    FOREIGN KEY (IdUser) REFERENCES USERS(IdUser),
    FOREIGN KEY (IdBadge) REFERENCES BADGES(IdBadge)
);

----- VIEW

-- THE LEADERBOARD GROUPED BY LANGUAGE

CREATE VIEW LEADERBOARD AS (
    SELECT IdUser, FirstName, LastName,
            AVG(TIMEDIFF(DateEnd, DateBegin)) AS Duration,
            LanguageS, ColorBadge,
            COUNT(DateEnd) AS ChallengeDone
    FROM SOLVE NATURAL JOIN USERS LEFT JOIN BADGES ON USERS.IdBadge = BADGES.IdBadge
    GROUP BY LanguageS, IdUser
    ORDER BY ChallengeDone DESC, Duration
);

-- MOST FREQUENT LANGUAGES

----- HARD SELECT REQUESTS

-- GET THE GLOBAL LEADERBOARD

SELECT * FROM (
    SELECT IdUser, FirstName, LastName, ColorBadge, LanguageS,
            AVG(Duration) AS AvgDur,
            SUM(ChallengeDone) AS TotalChal,
            (@i := @i + 1) AS Position
        FROM LEADERBOARD, (SELECT @i := 0) as IndexComputing
        GROUP BY IdUser
        ORDER BY TotalChal DESC, AvgDur
) AS GlobalLeaderboard ORDER BY Position LIMIT 50 OFFSET :startindex

-- Position lookup

SELECT Position FROM (
    SELECT IdUser, AVG(Duration) AS AvgDur, SUM(ChallengeDone) AS TotalChal,
            (@i := @i + 1) AS Position
        FROM LEADERBOARD, (SELECT @i := 0) as IndexComputing
        GROUP BY IdUser
        ORDER BY TotalChal DESC, AvgDur
) AS PositionComputing WHERE IdUser = :id

-- GET CHALLENGE LEADERBOARD

SELECT * FROM (
    SELECT IdUser, FirstName, LastName,
            TIME_TO_SEC(TIMEDIFF(DateEnd, DateBegin)) AS Duration,
            LanguageS, ColorBadge
        FROM SOLVE NATURAL JOIN USERS LEFT JOIN BADGES ON USERS.IdBadge = BADGES.IdBadge
        WHERE IdExercice = :exercice
        ORDER BY -Duration DESC
) AS ChallengeLeaderboard LIMIT 50 OFFSET :startindex;
