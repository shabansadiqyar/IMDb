
--The names of all actors in the movie 'Die Another Day'
SELECT DISTINCT CONCAT(first, ' ', last) FROM Actor AS a1, Movie AS m1, MovieActor AS ma1 WHERE a1.id=ma1.aid AND m1.id=ma1.mid AND m1.title='Die Another Day';

--The count of all the actors who acted in multiple movies
SELECT COUNT(id) actors_count FROM (SELECT Actor.id FROM MovieActor, Actor WHERE MovieActor.aid=Actor.id GROUP BY id HAVING COUNT(MovieActor.aid) > 1) X;

--The titles of movies that sell more than 1,000,000 tickets
SELECT DISTINCT title FROM Movie AS m1, MovieActor AS ma1, Sales AS s1 WHERE m1.id=ma1.mid AND ma1.mid=s1.mid AND s1.ticketsSold > 1000000;

--The titles and years that Pierce Brosnan acted in ascending order
SELECT DISTINCT title, year FROM Actor, Movie, MovieActor WHERE Actor.id=MovieActor.aid AND MovieActor.mid=Movie.id AND Actor.first='Pierce' AND Actor.last='Brosnan' ORDER BY year ASC;

--The titles of movies that're rated 80 or higher from imdb and rotten tomatos
SELECT DISTINCT title FROM Movie AS m1, MovieRating AS mr1 WHERE m1.id=mr1.mid AND (mr1.imdb > 79) AND (mr1.rot > 79); 
