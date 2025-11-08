CREATE DATABASE pemesanan_lapak;
USE pemesanan_lapak;

CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(100)
);

INSERT INTO admin (username, password) VALUES ('admin', '123');

CREATE TABLE lapak (
  id INT AUTO_INCREMENT PRIMARY KEY,
  no_lapak INT,
  status ENUM('kosong','dipesan') DEFAULT 'kosong'
);

INSERT INTO lapak (no_lapak, status) VALUES
(1,'kosong'), (2,'kosong'), (3,'kosong'), (4,'kosong'), (5,'kosong');

CREATE TABLE pesanan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  kontak VARCHAR(50),
  no_lapak INT,
  status ENUM('menunggu','disetujui') DEFAULT 'menunggu'
);
