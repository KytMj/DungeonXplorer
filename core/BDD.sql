drop table Class;
drop table Items;
drop table Loot;
drop table Trasures;
drop table Monster;
drop table hero;
drop table Level;
drop table Chapter;
drop table Encounter;
drop table Inventory;
drop table Links;
drop table Chapter_Treasure;
drop table Quest;


-- Création de la table Class (Classe des personnages)
CREATE TABLE Class (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    base_pv INT NOT NULL,
    base_mana INT NOT NULL,
    strength INT NOT NULL,
    initiative INT NOT NULL,
    max_items INT NOT NULL
);

-- Création de la table Items (Objets disponibles dans le jeu)
CREATE TABLE Items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT
);

-- Création de la table Loot (Butins des monstres)
CREATE TABLE Loot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    item_id INT, -- Relation avec Items
    quantity INT NOT NULL,
    FOREIGN KEY (item_id) REFERENCES Items(id)
);

-- Création de la table Treasure (Trésors dans les chapitres)
CREATE TABLE Treasure (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    item_id INT, -- Relation avec Items
    quantity INT NOT NULL,
    FOREIGN KEY (item_id) REFERENCES Items(id)
);

-- Création de la table Monster (Monstres rencontrés dans l'histoire)
CREATE TABLE Monster (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    pv INT NOT NULL,
    mana INT,
    initiative INT NOT NULL,
    strength INT NOT NULL,
    attack TEXT,
    loot_id INT, -- Relation avec Loot
    xp INT NOT NULL,
    FOREIGN KEY (loot_id) REFERENCES Loot(id)
);

-- Création de la table Hero (Personnage principal)
CREATE TABLE Hero (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    class_id INT, -- Relation avec Class
    image VARCHAR(255),
    biography TEXT,
    pv INT NOT NULL,
    mana INT NOT NULL,
    strength INT NOT NULL,
    initiative INT NOT NULL,
    armor VARCHAR(50),
    primary_weapon VARCHAR(50),
    secondary_weapon VARCHAR(50),
    shield VARCHAR(50),
    spell_list TEXT,
    xp INT NOT NULL,
    current_level INT DEFAULT 1,
    FOREIGN KEY (class_id) REFERENCES Class(id)
);

-- Création de la table Level (Niveaux de progression des classes)
CREATE TABLE Level (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT, -- Relation avec Class
    level INT NOT NULL,
    required_xp INT NOT NULL,
    pv_bonus INT NOT NULL,
    mana_bonus INT NOT NULL,
    strength_bonus INT NOT NULL,
    initiative_bonus INT NOT NULL,
    FOREIGN KEY (class_id) REFERENCES Class(id)
);

-- Création de la table Chapter (Chapitres de l'histoire)
CREATE TABLE `Chapter` (
  id int(11) NOT NULL,
  Titre text NOT NULL DEFAULT 'Titre',
  content text NOT NULL,
  image varchar(255) DEFAULT NULL,
  treasure_id int(11) DEFAULT NULL
);

-- Création de la table Encounter (Rencontres dans les chapitres)
CREATE TABLE Encounter (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chapter_id INT,
    monster_id INT,
    FOREIGN KEY (chapter_id) REFERENCES Chapter(id),
    FOREIGN KEY (monster_id) REFERENCES Monster(id)
);

-- Table intermédiaire pour l'inventaire des héros (Hero - Items)
CREATE TABLE Inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hero_id INT,
    item_id INT,
    FOREIGN KEY (hero_id) REFERENCES Hero(id),
    FOREIGN KEY (item_id) REFERENCES Items(id)
);

-- Création de la table Links (Liens entre chapitres)
CREATE TABLE Links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chapter_id INT,
    next_chapter_id INT,
    description TEXT,
    FOREIGN KEY (chapter_id) REFERENCES Chapter(id),
    FOREIGN KEY (next_chapter_id) REFERENCES Chapter(id)
);

-- Table intermédiaire pour les trésors dans les chapitres (Chapter - Items)
CREATE TABLE Chapter_Treasure (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chapter_id INT,
    item_id INT,
    FOREIGN KEY (chapter_id) REFERENCES Chapter(id),
    FOREIGN KEY (item_id) REFERENCES Items(id)
);

-- Table intermédiaire pour les quêtes des héros (Hero - Chapter)
CREATE TABLE Quest (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hero_id INT,
    chapter_id INT,
    FOREIGN KEY (hero_id) REFERENCES Hero(id),
    FOREIGN KEY (chapter_id) REFERENCES Chapter(id)
);


-- -------------------CHAPTERS---------------------------------------------------------------------------
insert into Chapter values (1, "Introduction","
Le ciel est lourd ce soir sur le village du Val Perdu, dissimulé entre les montagnes. La
petite taverne, dernier refuge avant l'immense forêt, est étrangement calme quand le
bourgmestre s’approche de vous. Homme d’apparence usée par les années et les soucis,
il vous adresse un regard désespéré.
« Ma fille… elle a disparu dans la forêt. Personne n’a osé la chercher… sauf vous, peut-
être ? On raconte qu’un sorcier vit dans un château en ruines, caché au cœur des bois.
Depuis des mois, des jeunes filles disparaissent… J'ai besoin de vous pour la retrouver. »
Vous sentez le poids de la mission qui s’annonce, et un frisson parcourt votre échine.
Bientôt, la forêt s'ouvre devant vous, sombre et menaçante. La quête commence.", "Village01.jpg", NULL);

insert into Chapter values (2, "L'orée de la forêt",
"Vous franchissez la lisière des arbres, la pénombre de la forêt avalant le sentier devant
vous. Un vent froid glisse entre les troncs, et le bruissement des feuilles ressemble à un
murmure menaçant. Deux chemins s’offrent à vous : l’un sinueux, bordé de vieux arbres
noueux ; l’autre droit mais envahi par des ronces épaisses.", "brambleTrails01.jpg", NULL);

insert into Chapter values (3, "L'arbre aux corbeaux",
"Votre choix vous mène devant un vieux chêne aux branches tordues, grouillant de
corbeaux noirs qui vous observent en silence. À vos pieds, des traces de pas légers,
probablement récents, mènent plus loin dans les bois. Soudain, un bruit de pas feutrés
se fait entendre. Vous ressentez la présence d’un prédateur.", "Dark Forest02.jpg", NULL);

insert into Chapter values (4,"Le sanglier enragé",
"En progressant, le calme de la forêt est soudain brisé par un grognement. Surgissant des
buissons, un énorme sanglier, au pelage épais et aux yeux injectés de sang, se dirige vers
vous. Sa rage est palpable, et il semble prêt à en découdre. Le voici qui décide
brutalement de vous charger !", "Wild boar.jpg", NULL);

insert into Chapter values (5,"Rencontre avec le paysan",
"Tandis que vous progressez, une voix humaine s’élève, interrompant le silence de la forêt.
Vous tombez sur un vieux paysan, accroupi près de champignons aux couleurs vives. Il
sursaute en vous voyant, puis se détend, vous souriant tristement.
« Vous devriez faire attention, étranger, murmure-t-il. La nuit, des cris terrifiants
retentissent depuis le cœur de la forêt… Des créatures rôdent. »","OldMan01.jpg",NULL);

insert into Chapter values (6,"Le loup noir",
"À mesure que vous avancez, un bruissement attire votre attention. Une silhouette sombre
s’élance soudainement devant vous : un loup noir aux yeux perçants. Son poil est hérissé
et sa gueule laisse entrevoir des crocs acérés. Vous sentez son regard fixé sur vous, prêt
à bondir.
Le combat est inévitable", "Wolf01.jpg",NULL);

insert into Chapter values (7, "La clairière aux pierres anciennes",
"Après votre rencontre, vous atteignez une clairière étrange, entourée de pierres dressées,
comme un ancien autel oublié par le temps. Une légère brume rampe au sol, et les
ombres des pierres semblent danser sous la lueur de la lune.",  "StoneWall01.jpg" , NULL );

insert into Chapter values (8, "Les murmures du ruisseau",
"Essoufflé mais déterminé, vous arrivez près d’un petit ruisseau qui serpente au milieu des
arbres. Le chant de l’eau vous apaise quelque peu, mais des murmures étranges
semblent émaner de la rive. Vous apercevez des inscriptions anciennes gravées dans une
pierre moussue.", "StoneWall02.jpg",NULL);

insert into Chapter values (9, "Au pied du château",
"La forêt se disperse enfin, et devant vous se dresse une colline escarpée. Au sommet, le
château en ruines projette une ombre menaçante sous le clair de lune. Les murs effrités
et les tours en partie effondrées ajoutent à la sinistre réputation du lieu.
Vous sentez que la véritable aventure commence ici, et que l’influence du sorcier n’est
peut-être pas qu’une légende…", "DarkCastle02.jpg", NULL);

insert into Chapter values (10, "La lumière au bout du néant",
"Le monde se dérobe sous vos pieds, et une obscurité profonde vous enveloppe, glaciale
et insondable. Vous ne sentez plus le poids de votre équipement, ni la morsure de la
douleur. Juste un vide infini, vous aspirant lentement dans les ténèbres.
Alors que vous perdez toute notion du temps, une lueur douce apparaît au loin, vacillante
comme une flamme fragile dans l’obscurité. Au fur et à mesure que vous approchez, vous
entendez une voix, faible mais bienveillante, qui murmure des mots oubliés, anciens.
« Brave âme, ton chemin n'est pas achevé... À ceux qui échouent, une seconde chance
est accordée. Mais les caprices du destin exigent un sacrifice. »
La lumière s'intensifie, et vous sentez vos forces revenir, mais vos poches sont vides, votre
sac allégé de tout trésor. Votre équipement, vos armes, tout a disparu, laissant place à
une sensation de vulnérabilité.
Lorsque la lumière vous enveloppe, vous ouvrez de nouveau les yeux, retrouvant la terre
ferme sous vos pieds. Vous êtes de retour, sans autre possession que votre volonté de
reprendre cette quête. Mais cette fois-ci, peut-être, saurez-vous éviter les pièges fatals
qui vous ont mené à votre perte.
• Si vous souhaitez reprendre l’aventure depuis le début, rendez-vous de nouveau
au chapitre 1." , "Helmet.jpg", NULL);

insert into Chapter values (11, "Chapitre 11 : La curiosité tua le chat
Qu’avez-vous fait, Malheureux !", null, null);


-- ---------------------------------LINKS-----------------------------------------------------
insert into Links values (1, 1, 2, "Continuer");

insert into Links values (2, 2, 3, "Emprunter le chemin sinueux");
insert into Links values (3, 2, 4, "Choisir le sentier couvert de ronces");

insert into Links values (4, 3, 5, "Choisir de rester prudent");
insert into Links values (5, 3, 6, "Décider d’ignorer les bruits et de poursuivre la route");


insert into Links values (6, 4, 8, "Le sanglier est vaincu !");
insert into Links values (7, 4, 10, "Le sanglier vous a vaincu...");

insert into Links values (8, 5, 7, "Continuer");

insert into Links values (9, 6, 7, "Le loup noir est vaincu !");
insert into Links values (10, 6, 10, "Le loup noir vous a vaincu...");

insert into Links values (11, 7, 8, "Décider de prendre le sentier couvert de mousse");
insert into Links values (12, 7, 9, "Choisir de suivre le chemin tortueux à travers les racines");

insert into Links values (13, 8, 9, "Ignorer cette curiosité et poursuivre votre route");
insert into Links values (14, 8, 11, "Toucher la pierre gravée");

-- 9

-- 10

insert into Links values (15, 10, 1, "C'est reparti !!!");

insert into Links values (16, 11, 10, "Voir le sort qui vous attend...");


-- -------------------------------MONSTER---------------------------------------------------------
insert into Items values (1, "défences de sanglier", "valent beacoup d'or");

insert into Items values (2, "peau de loup", "peut être utilisée comme cape");

insert into Loot values(1, "récompenses du sanglier", 1, 2);

insert into Loot values (2, "récompenses du loup", 2, 1);

insert into Monster values (1, "sanglier", 30, 0, 2, 3, "charge", 1, 50 );

insert into Monster values (2, "loup", 15, 0, 20, 2, "frostbite", 2, 30);

-- --------------------------------CLASSES----------------------------------------------------------
insert into Class values (1, "guerrier", "tape fort avec beaucoup de points de vie mais manque d'initiative et de mana.", 30, 0, 5, 5, 5);
insert into Class values (2, "voleur", "rempli de malice il tape fort avec une grande initiative mais manque de points de vie mais et de mana.", 20, 10, 4, 50, 7);
insert into Class values (3, "magicien", "une classe très variée avec beaucoup d'options mais des stats réduites", 20, 30, 1, 15, 3);

-- --------------------------------LEVELS--------------------------------------------------------------
-- non

-- ------------------------------encounters------------------------------------------------------------
insert into Encounter values (1, 4, 1);  -- sanglier et chapitre 4
insert into Encounter values (2, 6, 2); -- chapitre 6 et loup