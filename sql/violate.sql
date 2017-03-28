--PRIMARY KEY CONSTRAINTS *********************

UPDATE Movie SET id=25 WHERE id=35;
--ERROR: duplicate entry '25' for key 1;

UPDATE Actor SET id=25 WHERE id=35;
--ERROR: duplicate entry '25' for key 1;

UPDATE Director SET id=25 WHERE id=35;
--ERROR: duplicate entry '25' for key 1;

--Movie, Actor, and Director have primary keys for id, therefore there is an error when I try to update the id to another value that already exists in the table. 

--REFERENTIAL INTEGRITY CONSTRAINTS *******************

INSERT INTO MovieGenre(mid, genre) VALUE("324, "Action");
--#ERROR: can't update or add a child row because a foreign constraint fails
--There is an error for the foreign keys for mid

INSERT INTO MovieDirector(mid, did) VALUE("324, "646");
--#ERROR: can't update or add a child row because a foreign constraint fails
--#ERROR: can't update or add a child row because a foreign constraint fails
--These errors are for the two foreign keys for mid and did

INSERT INTO MovieActor(mid, aid, role) VALUE("324, "646", "Himself");
--#ERROR: can't update or add a child row because a foreign constraint fails
--#ERROR: can't update or add a child row because a foreign constraint fails
--These errors are for the two foreign keys for mid and aid

INSERT INTO Review(name, time, mid, rating, comment) VALUE("Bob", CURRENT_TIMESTAMP, "564", "3", "good");
--#ERROR: can't update or add a child row because a foreign constraint fails
--There is an error for the foriegn key to mid

--CHECK CONSTRAINTS *****************

INSERT INTO Actor(id, last, first, sex, dob) VALUE(646451, "x", "y", "Male", "2050-04-17");
--error for violating the dob, can't be after the current date

INSERT INTO Director(id, last, first, dob, dod) VALUE(646451, "x", "y", "Male", "2050-04-17", NULL);
--error for violating the dob, can't be after the current date

--Actor and Director both have check constraints for the dob to not be a value in the future since this isn't possible

INSERT INTO Review(name, time, mid, rating, comment) VALUE("x", CURRENT_TIMESTAMP, "232", "50", "good");
--error violates the upper bound of rating

--The Review rating can only be between 0 and 5. Anything else will cause an error
