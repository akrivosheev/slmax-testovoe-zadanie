create table people
(
  id        int auto_increment
    primary key,
  name      text       null,
  surname   text       null,
  birthdate date       null,
  gender    tinyint(1) null,
  city      text       null
);

INSERT INTO tcw.people (id, name, surname, birthdate, gender, city) VALUES (1, 'Семён', 'Персунов', '1990-01-01', 1, 'New York');
INSERT INTO tcw.people (id, name, surname, birthdate, gender, city) VALUES (2, 'John', 'Doe', '1990-01-01', 0, 'New York');
INSERT INTO tcw.people (id, name, surname, birthdate, gender, city) VALUES (6, 'Вася', 'Пупкин', '1990-01-01', 0, 'Крыжополь');
INSERT INTO tcw.people (id, name, surname, birthdate, gender, city) VALUES (7, 'Семён', 'Персунов', '1987-09-04', 0, 'Los Angeles');
INSERT INTO tcw.people (id, name, surname, birthdate, gender, city) VALUES (8, 'Алиса', 'Двачевская', '1972-01-01', 1, 'Смоленск');
INSERT INTO tcw.people (id, name, surname, birthdate, gender, city) VALUES (9, 'Алиса', 'Двачевская', '1972-01-01', 1, 'Смоленск');
INSERT INTO tcw.people (id, name, surname, birthdate, gender, city) VALUES (10, 'John', 'Doe', '1990-01-01', 1, 'Las Angeles');
INSERT INTO tcw.people (id, name, surname, birthdate, gender, city) VALUES (11, 'John', 'Jackson', '1990-01-01', 1, 'New York');
INSERT INTO tcw.people (id, name, surname, birthdate, gender, city) VALUES (12, 'John', 'Russo', '1990-01-23', 1, 'New York');
INSERT INTO tcw.people (id, name, surname, birthdate, gender, city) VALUES (13, 'Семён', 'Персунов', '1990-01-30', 1, 'New York');