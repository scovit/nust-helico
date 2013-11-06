CREATE USER 'clusterizator'@'localhost' IDENTIFIED BY PASSWORD '*E2A5DBC02A6F440378FA09C3DB28E2719365D377'
GRANT ALL PRIVILEGES ON clusterizator TO 'clusterizator'@'localhost'
create table lists ( rec_id INT AUTO_INCREMENT PRIMARY KEY, code VARCHAR(8), directory VARCHAR(40) );
create database clusterizator;
create table genes (rec_id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(10), start_position INT, end_position INT); 
load data infile '/var/www/clusterizator/analizzatore/data/position.txt' replace into table genes fields terminated by '\t' lines terminated by '\n' (name, start_position, end_position);
