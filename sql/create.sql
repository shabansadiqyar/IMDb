CREATE TABLE Movie(id int NOT NULL, title varchar(100) NOT NULL, year int, rating varchar(10), company varchar(50), PRIMARY KEY (id)) ENGINE=INNODB;

CREATE TABLE Actor(id int NOT NULL, last varchar(20) NOT NULL, first varchar(20) NOT NULL, sex varchar(6), dob date NOT NULL, dod date, PRIMARY KEY (id), CHECK (dob<= CURDATE())) ENGINE=INNODB;

CREATE TABLE Sales(mid int NOT NULL, ticketsSold int, totalIncome int, PRIMARY KEY (mid)) ENGINE=INNODB;

CREATE TABLE Director(id int NOT NULL, last varchar(20) NOT NULL, first varchar(20) NOT NULL, dob date NOT NULL, dod date, PRIMARY KEY (id), CHECK (dob <= CURDATE())) ENGINE=INNODB;

CREATE TABLE MovieGenre(mid int NOT NULL, genre varchar(20), PRIMARY KEY (mid,genre), FOREIGN KEY (mid) references Movie(id)) ENGINE=INNODB;

CREATE TABLE MovieDirector(mid int NOT NULL, did int NOT NULL, PRIMARY KEY (mid, did), FOREIGN KEY (mid) references Movie(id), FOREIGN KEY (did) references Director(id)) ENGINE=INNODB;

CREATE TABLE MovieActor(mid int NOT NULL, aid int NOT NULL, role varchar(50), PRIMARY KEY (mid, aid), FOREIGN KEY (mid) references Movie(id), FOREIGN KEY (aid) references Actor(id)) ENGINE=INNODB;

CREATE TABLE MovieRating(mid int NOT NULL, imdb int NOT NULL, rot int NOT NULL, PRIMARY KEY (mid)) ENGINE=INNODB;

CREATE TABLE Review(name varchar(20) NOT NULL, time timestamp, mid int NOT NULL, rating int NOT NULL, comment varchar(500), PRIMARY KEY (name, mid), FOREIGN KEY (mid) references Movie(id), CHECK (rating>=0 AND rating<=5)) ENGINE=INNODB;

CREATE TABLE MaxPersonID(id int NOT NULL) ENGINE=INNODB;

CREATE TABLE MaxMovieID(id int NOT NULL) ENGINE=INNODB;
