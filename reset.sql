FLUSH PRIVILEGES; 
ALTER USER "root"@"localhost" IDENTIFIED BY "asdf@1234"; 
CREATE USER IF NOT EXISTS "shopsuite"@"localhost" IDENTIFIED BY "shopsuite@2024";
ALTER USER "shopsuite"@"localhost" IDENTIFIED BY "shopsuite@2024";
CREATE DATABASE IF NOT EXISTS shopsuite;
GRANT ALL PRIVILEGES ON shopsuite.* TO "shopsuite"@"localhost";
FLUSH PRIVILEGES;
