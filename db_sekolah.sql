CREATE DATABASE IF NOT EXISTS db_sekolah;
USE db_sekolah;

CREATE TABLE IF NOT EXISTS peserta_didik (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin VARCHAR(20) NOT NULL,
    agama VARCHAR(50) NOT NULL,
    nik VARCHAR(20) NOT NULL,
    no_kk VARCHAR(20) NOT NULL,
    tempat_tanggal_lahir VARCHAR(100) NOT NULL,
    nama_ayah VARCHAR(100) NOT NULL,
    nama_ibu VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    no_tlp VARCHAR(20) NOT NULL,
    ekstrakurikuler VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password) VALUES ('admin', 'admin123');