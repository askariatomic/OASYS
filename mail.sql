-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Sep 13, 2012 at 03:33 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `mail`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_akun_pegawai`
-- 

CREATE TABLE `oasys_akun_pegawai` (
  `NIP` varchar(20) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `LAST_LOGIN` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`NIP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_arsip`
-- 

CREATE TABLE `oasys_arsip` (
  `KD_ARSIP` int(11) NOT NULL auto_increment,
  `NOMOR_DOKUMEN` varchar(255) NOT NULL,
  `NIP` varchar(20) NOT NULL,
  `TANGGAL` date NOT NULL default '0000-00-00',
  `PERIHAL` varchar(255) NOT NULL,
  `KEPADA` varchar(255) NOT NULL,
  `INSTITUSI` varchar(255) NOT NULL,
  `ALAMAT` text NOT NULL,
  `KD_JENIS_DOKUMEN` varchar(20) NOT NULL,
  `JUMLAH_DOKUMEN` varchar(10) default NULL,
  `NAMA_DOKUMEN` varchar(255) NOT NULL,
  `UKURAN_DOKUMEN` int(11) NOT NULL,
  `TIPE_DOKUMEN` varchar(255) NOT NULL,
  `DIREKTORI_DOKUMEN` varchar(255) NOT NULL,
  `TANGGAL_MASUK_DOKUMEN` date NOT NULL default '0000-00-00',
  `TANGGAL_RETENSI` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`KD_ARSIP`),
  KEY `fk_dokumen_nip` (`NIP`),
  KEY `fk_dokumen_jenis_dokumen` (`KD_JENIS_DOKUMEN`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_bidang`
-- 

CREATE TABLE `oasys_bidang` (
  `KD_BIDANG` varchar(20) NOT NULL,
  `BIDANG` varchar(255) NOT NULL,
  PRIMARY KEY  (`KD_BIDANG`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_disposisi`
-- 

CREATE TABLE `oasys_disposisi` (
  `KD_DISPOSISI` int(11) NOT NULL auto_increment,
  `KD_SURAT` int(11) NOT NULL,
  `NIP` varchar(20) NOT NULL,
  `TANGGAL` timestamp NOT NULL default '0000-00-00 00:00:00',
  `DARI` varchar(255) NOT NULL,
  `TANGGAL_MASUK` timestamp NOT NULL default '0000-00-00 00:00:00',
  `TANGGAL_SURAT` date NOT NULL,
  `SIFAT_SURAT` varchar(20) NOT NULL,
  `NOMOR_SURAT` varchar(255) NOT NULL,
  `PERIHAL` varchar(255) NOT NULL,
  `ISI_SURAT` text NOT NULL,
  `KOMENTAR` text NOT NULL,
  `NAMA_FILE` varchar(255) default NULL,
  `UKURAN_FILE` int(11) default NULL,
  `TIPE_FILE` varchar(255) default NULL,
  `DIREKTORI_FILE` varchar(255) default NULL,
  PRIMARY KEY  (`KD_DISPOSISI`),
  KEY `fk_disposisi` (`NIP`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_email_konsep_surat_keluar_eksternal`
-- 

CREATE TABLE `oasys_email_konsep_surat_keluar_eksternal` (
  `KD_EMAIL_KONSEP_SURAT_KELUAR_EKSTERNAL` int(11) NOT NULL auto_increment,
  `KD_SURAT` int(11) NOT NULL,
  `EMAIL` varchar(255) default NULL,
  PRIMARY KEY  (`KD_EMAIL_KONSEP_SURAT_KELUAR_EKSTERNAL`),
  KEY `fk_email_konsep_surat_keluar_eksternal` (`KD_SURAT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_email_surat_keluar_eksternal`
-- 

CREATE TABLE `oasys_email_surat_keluar_eksternal` (
  `KD_EMAIL_SURAT_KELUAR_EKSTERNAL` int(11) NOT NULL auto_increment,
  `KD_SURAT` int(11) NOT NULL,
  `EMAIL` varchar(255) default NULL,
  PRIMARY KEY  (`KD_EMAIL_SURAT_KELUAR_EKSTERNAL`),
  KEY `fk_email_surat_keluar_eksternal_kd_surat` (`KD_SURAT`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_institusi`
-- 

CREATE TABLE `oasys_institusi` (
  `KD_INSTITUSI` varchar(20) NOT NULL,
  `NAMA_INSTITUSI` varchar(255) NOT NULL,
  `ALAMAT` text,
  `TELEPON` varchar(100) default NULL,
  `EMAIL` varchar(100) default NULL,
  PRIMARY KEY  (`KD_INSTITUSI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_jabatan_struktural`
-- 

CREATE TABLE `oasys_jabatan_struktural` (
  `KD_JS` varchar(20) NOT NULL,
  `KD_INSTITUSI` varchar(20) NOT NULL,
  `NAMA_JABATAN` varchar(255) NOT NULL,
  `KD_UNIT` varchar(255) NOT NULL,
  `UNIT` varchar(255) NOT NULL,
  PRIMARY KEY  (`KD_JS`,`KD_UNIT`,`UNIT`),
  KEY `fk_jabatan_struktural` (`KD_INSTITUSI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_jabatan_struktural_pegawai`
-- 

CREATE TABLE `oasys_jabatan_struktural_pegawai` (
  `NIP` varchar(20) NOT NULL,
  `KD_JA` varchar(20) NOT NULL,
  `KD_JS` varchar(20) NOT NULL,
  `KD_UNIT` varchar(255) NOT NULL,
  `UNIT` varchar(255) NOT NULL,
  PRIMARY KEY  (`NIP`,`KD_JS`),
  KEY `fk_jabatan_struktural_pegawai_js` (`KD_JS`,`KD_UNIT`,`UNIT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_jenis_dokumen`
-- 

CREATE TABLE `oasys_jenis_dokumen` (
  `KD_JENIS_DOKUMEN` varchar(20) NOT NULL,
  `JENIS_DOKUMEN` varchar(2) NOT NULL,
  PRIMARY KEY  (`KD_JENIS_DOKUMEN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_kategori`
-- 

CREATE TABLE `oasys_kategori` (
  `KATEGORI` varchar(255) NOT NULL,
  `KD_BIDANG` varchar(20) NOT NULL,
  PRIMARY KEY  (`KATEGORI`),
  KEY `fk_kategori` (`KD_BIDANG`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_kepada_disposisi`
-- 

CREATE TABLE `oasys_kepada_disposisi` (
  `KD_KEPADA_DISPOSISI` int(11) NOT NULL auto_increment,
  `KD_STATUS` varchar(20) NOT NULL default 'unread',
  `KD_DISPOSISI` int(11) NOT NULL,
  `KEPADA` varchar(20) NOT NULL,
  PRIMARY KEY  (`KD_KEPADA_DISPOSISI`),
  KEY `fk_kepada_disposisi_kd_status` (`KD_STATUS`),
  KEY `fk_kepada_disposisi_kd_disposisi` (`KD_DISPOSISI`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_kepada_konsep_surat_internal`
-- 

CREATE TABLE `oasys_kepada_konsep_surat_internal` (
  `KD_KEPADA_KONSEP_SURAT_INTERNAL` int(11) NOT NULL auto_increment,
  `KD_SURAT` int(11) NOT NULL,
  `KEPADA` varchar(20) NOT NULL,
  PRIMARY KEY  (`KD_KEPADA_KONSEP_SURAT_INTERNAL`),
  KEY `fk_kepada_konsep_surat_internal` (`KD_SURAT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_kepada_konsep_surat_keluar_eksternal`
-- 

CREATE TABLE `oasys_kepada_konsep_surat_keluar_eksternal` (
  `KD_KEPADA_KONSEP_SURAT_KELUAR_EKSTERNAL` int(11) NOT NULL auto_increment,
  `KD_SURAT` int(11) NOT NULL,
  `KEPADA` varchar(20) NOT NULL,
  PRIMARY KEY  (`KD_KEPADA_KONSEP_SURAT_KELUAR_EKSTERNAL`),
  KEY `fk_kepada_konsep_surat_keluar_eksternal` (`KD_SURAT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_kepada_surat_internal`
-- 

CREATE TABLE `oasys_kepada_surat_internal` (
  `KD_KEPADA_SURAT_INTERNAL` int(11) NOT NULL auto_increment,
  `KD_STATUS` varchar(20) NOT NULL default 'unread',
  `KD_SURAT` int(11) NOT NULL,
  `KEPADA` varchar(20) NOT NULL,
  PRIMARY KEY  (`KD_KEPADA_SURAT_INTERNAL`),
  KEY `fk_kepada_surat_internal_kd_status` (`KD_STATUS`),
  KEY `fk_kepada_surat_internal_kd_surat` (`KD_SURAT`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_kepada_surat_keluar_eksternal`
-- 

CREATE TABLE `oasys_kepada_surat_keluar_eksternal` (
  `KD_KEPADA_SURAT_KELUAR_EKSTERNAL` int(11) NOT NULL auto_increment,
  `KD_SURAT` int(11) NOT NULL,
  `KEPADA` varchar(20) NOT NULL,
  PRIMARY KEY  (`KD_KEPADA_SURAT_KELUAR_EKSTERNAL`),
  KEY `fk_kepada_surat_keluar_eksternal_kd_surat` (`KD_SURAT`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_kepada_surat_masuk_eksternal`
-- 

CREATE TABLE `oasys_kepada_surat_masuk_eksternal` (
  `KD_KEPADA_SURAT_MASUK_EKSTERNAL` int(11) NOT NULL auto_increment,
  `KD_STATUS` varchar(20) NOT NULL default 'unread',
  `KD_SURAT` int(11) NOT NULL,
  `KEPADA` varchar(20) NOT NULL,
  PRIMARY KEY  (`KD_KEPADA_SURAT_MASUK_EKSTERNAL`),
  KEY `fk_kepada_surat_masuk_eksternal_kd_status` (`KD_STATUS`),
  KEY `fk_kepada_surat_masuk_eksternal_kd_surat` (`KD_SURAT`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_kepada_verifikasi`
-- 

CREATE TABLE `oasys_kepada_verifikasi` (
  `KD_KEPADA_VERIFIKASI` int(11) NOT NULL auto_increment,
  `KD_STATUS` varchar(20) NOT NULL default 'unread',
  `KD_VERIFIKASI` int(11) NOT NULL,
  `KEPADA` varchar(20) NOT NULL,
  PRIMARY KEY  (`KD_KEPADA_VERIFIKASI`),
  KEY `fk_kepada_verifikasi_kd_status` (`KD_STATUS`),
  KEY `fk_kepada_verifikasi_kd_verifikasi` (`KD_VERIFIKASI`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_klasifikasi`
-- 

CREATE TABLE `oasys_klasifikasi` (
  `KD_KLASIFIKASI` varchar(20) NOT NULL,
  `KATEGORI` varchar(255) NOT NULL,
  `KLASIFIKASI` varchar(255) NOT NULL,
  `RUANG_LINGKUP` varchar(255) default NULL,
  PRIMARY KEY  (`KD_KLASIFIKASI`),
  KEY `fk_klasifikasi` (`KATEGORI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_konsep_surat_internal`
-- 

CREATE TABLE `oasys_konsep_surat_internal` (
  `KD_SURAT` int(11) NOT NULL auto_increment,
  `NIP` varchar(20) NOT NULL,
  `TANGGAL` timestamp NOT NULL default '0000-00-00 00:00:00',
  `TANGGAL_SURAT` date NOT NULL,
  `SIFAT_SURAT` varchar(20) NOT NULL,
  `NOMOR_SURAT` varchar(255) NOT NULL,
  `PERIHAL` varchar(255) NOT NULL,
  `ISI_SURAT` text NOT NULL,
  `NAMA_FILE` varchar(255) default NULL,
  `UKURAN_FILE` int(11) default NULL,
  `TIPE_FILE` varchar(255) default NULL,
  `DIREKTORI_FILE` varchar(255) default NULL,
  PRIMARY KEY  (`KD_SURAT`),
  KEY `fk_konsep_surat_internal_nip` (`NIP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_konsep_surat_keluar_eksternal`
-- 

CREATE TABLE `oasys_konsep_surat_keluar_eksternal` (
  `KD_SURAT` int(11) NOT NULL auto_increment,
  `NIP` varchar(20) NOT NULL,
  `TANGGAL` timestamp NOT NULL default '0000-00-00 00:00:00',
  `TANGGAL_SURAT` date NOT NULL,
  `SIFAT_SURAT` varchar(20) NOT NULL,
  `NOMOR_SURAT` varchar(255) NOT NULL,
  `PERIHAL` varchar(255) NOT NULL,
  `ALAMAT` text,
  `ISI_SURAT` text NOT NULL,
  `NAMA_FILE` varchar(255) default NULL,
  `UKURAN_FILE` int(11) default NULL,
  `TIPE_FILE` varchar(255) default NULL,
  `DIREKTORI_FILE` varchar(255) default NULL,
  PRIMARY KEY  (`KD_SURAT`),
  KEY `fk_konsep_surat_keluar_eksternal_nip` (`NIP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_letak_arsip`
-- 

CREATE TABLE `oasys_letak_arsip` (
  `KD_LETAK` int(11) NOT NULL auto_increment,
  `KD_ARSIP` int(11) NOT NULL,
  `LEMARI` varchar(20) NOT NULL,
  `RAK` varchar(20) NOT NULL,
  `FOLDER` varchar(20) NOT NULL,
  `MAP` varchar(20) NOT NULL,
  `POSISI` varchar(20) NOT NULL,
  PRIMARY KEY  (`KD_LETAK`),
  KEY `fk_letak_dokumen` (`KD_ARSIP`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_pegawai`
-- 

CREATE TABLE `oasys_pegawai` (
  `NIP` varchar(20) NOT NULL,
  `NAMA` varchar(100) default NULL,
  `TELEPON` varchar(100) default NULL,
  `EMAIL` varchar(255) default NULL,
  PRIMARY KEY  (`NIP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_status_surat`
-- 

CREATE TABLE `oasys_status_surat` (
  `KD_STATUS` varchar(20) NOT NULL,
  `STATUS_SURAT` varchar(255) NOT NULL,
  PRIMARY KEY  (`KD_STATUS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_surat_internal`
-- 

CREATE TABLE `oasys_surat_internal` (
  `KD_SURAT` int(11) NOT NULL auto_increment,
  `NIP` varchar(20) NOT NULL,
  `TANGGAL` timestamp NOT NULL default '0000-00-00 00:00:00',
  `TANGGAL_SURAT` date NOT NULL,
  `SIFAT_SURAT` varchar(20) NOT NULL,
  `NOMOR` int(11) NOT NULL default '0',
  `KD_INSTITUSI` varchar(20) NOT NULL,
  `NOMOR_SURAT` varchar(255) NOT NULL,
  `PERIHAL` varchar(255) NOT NULL,
  `ISI_SURAT` text NOT NULL,
  `NAMA_FILE` varchar(255) default NULL,
  `UKURAN_FILE` int(11) default NULL,
  `TIPE_FILE` varchar(255) default NULL,
  `DIREKTORI_FILE` varchar(255) default NULL,
  PRIMARY KEY  (`KD_SURAT`),
  KEY `fk_surat_internal_nip` (`NIP`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_surat_keluar_eksternal`
-- 

CREATE TABLE `oasys_surat_keluar_eksternal` (
  `KD_SURAT` int(11) NOT NULL auto_increment,
  `NIP` varchar(20) NOT NULL,
  `TANGGAL` timestamp NOT NULL default '0000-00-00 00:00:00',
  `TANGGAL_SURAT` date NOT NULL,
  `SIFAT_SURAT` varchar(20) NOT NULL,
  `NOMOR` int(11) NOT NULL default '0',
  `KD_INSTITUSI` varchar(20) NOT NULL,
  `NOMOR_SURAT` varchar(255) NOT NULL,
  `PERIHAL` varchar(255) NOT NULL,
  `ALAMAT` text,
  `ISI_SURAT` text NOT NULL,
  `NAMA_FILE` varchar(255) default NULL,
  `UKURAN_FILE` int(11) default NULL,
  `TIPE_FILE` varchar(255) default NULL,
  `DIREKTORI_FILE` varchar(255) default NULL,
  PRIMARY KEY  (`KD_SURAT`),
  KEY `fk_surat_keluar_eksternal_nip` (`NIP`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_surat_masuk_eksternal`
-- 

CREATE TABLE `oasys_surat_masuk_eksternal` (
  `KD_SURAT` int(11) NOT NULL auto_increment,
  `NIP` varchar(20) NOT NULL,
  `TANGGAL` timestamp NOT NULL default '0000-00-00 00:00:00',
  `DARI` varchar(20) NOT NULL,
  `ALAMAT` text,
  `TANGGAL_DITERIMA` date NOT NULL,
  `TANGGAL_SURAT` date NOT NULL,
  `SIFAT_SURAT` varchar(20) NOT NULL,
  `NOMOR_SURAT` varchar(255) NOT NULL,
  `PERIHAL` varchar(255) NOT NULL,
  `KOMENTAR` text NOT NULL,
  `NAMA_FILE` varchar(255) default NULL,
  `UKURAN_FILE` int(11) default NULL,
  `TIPE_FILE` varchar(255) default NULL,
  `DIREKTORI_FILE` varchar(255) default NULL,
  PRIMARY KEY  (`KD_SURAT`),
  KEY `fk_surat_masuk_eksternal_nip` (`NIP`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_tembusan_konsep_surat_internal`
-- 

CREATE TABLE `oasys_tembusan_konsep_surat_internal` (
  `KD_TEMBUSAN_KONSEP_SURAT_INTERNAL` int(11) NOT NULL auto_increment,
  `KD_SURAT` int(11) NOT NULL,
  `TEMBUSAN` varchar(20) default NULL,
  PRIMARY KEY  (`KD_TEMBUSAN_KONSEP_SURAT_INTERNAL`),
  KEY `fk_tembusan_konsep_surat_internal` (`KD_SURAT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_tembusan_konsep_surat_keluar_eksternal`
-- 

CREATE TABLE `oasys_tembusan_konsep_surat_keluar_eksternal` (
  `KD_TEMBUSAN_KONSEP_SURAT_KELUAR_EKSTERNAL` int(11) NOT NULL auto_increment,
  `KD_SURAT` int(11) NOT NULL,
  `TEMBUSAN` varchar(20) default NULL,
  PRIMARY KEY  (`KD_TEMBUSAN_KONSEP_SURAT_KELUAR_EKSTERNAL`),
  KEY `fk_tembusan_konsep_surat_keluar_eksternal` (`KD_SURAT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_tembusan_surat_internal`
-- 

CREATE TABLE `oasys_tembusan_surat_internal` (
  `KD_TEMBUSAN_SURAT_INTERNAL` int(11) NOT NULL auto_increment,
  `KD_STATUS` varchar(20) NOT NULL default 'unread',
  `KD_SURAT` int(11) NOT NULL,
  `TEMBUSAN` varchar(20) default NULL,
  PRIMARY KEY  (`KD_TEMBUSAN_SURAT_INTERNAL`),
  KEY `fk_tembusan_surat_internal_kd_status` (`KD_STATUS`),
  KEY `fk_tembusan_surat_internal_kd_surat` (`KD_SURAT`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_tembusan_surat_keluar_eksternal`
-- 

CREATE TABLE `oasys_tembusan_surat_keluar_eksternal` (
  `KD_TEMBUSAN_SURAT_KELUAR_EKSTERNAL` int(11) NOT NULL auto_increment,
  `KD_SURAT` int(11) NOT NULL,
  `TEMBUSAN` varchar(20) default NULL,
  PRIMARY KEY  (`KD_TEMBUSAN_SURAT_KELUAR_EKSTERNAL`),
  KEY `fk_tembusan_surat_keluar_eksternal_kd_surat` (`KD_SURAT`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_tembusan_surat_masuk_eksternal`
-- 

CREATE TABLE `oasys_tembusan_surat_masuk_eksternal` (
  `KD_TEMBUSAN_SURAT_MASUK_EKSTERNAL` int(11) NOT NULL auto_increment,
  `KD_STATUS` varchar(20) NOT NULL default 'unread',
  `KD_SURAT` int(11) NOT NULL,
  `TEMBUSAN` varchar(20) default NULL,
  PRIMARY KEY  (`KD_TEMBUSAN_SURAT_MASUK_EKSTERNAL`),
  KEY `fk_tembusan_surat_masuk_eksternal_kd_status` (`KD_STATUS`),
  KEY `fk_tembusan_surat_masuk_eksternal_kd_surat` (`KD_SURAT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `oasys_verifikasi`
-- 

CREATE TABLE `oasys_verifikasi` (
  `KD_VERIFIKASI` int(11) NOT NULL auto_increment,
  `NIP` varchar(20) NOT NULL,
  `TANGGAL` timestamp NOT NULL default '0000-00-00 00:00:00',
  `TANGGAL_SURAT` date NOT NULL,
  `SIFAT_SURAT` varchar(20) NOT NULL,
  `NOMOR_SURAT` varchar(255) NOT NULL,
  `PERIHAL` varchar(255) NOT NULL,
  `ISI_SURAT` text NOT NULL,
  `NAMA_FILE` varchar(255) default NULL,
  `UKURAN_FILE` int(11) default NULL,
  `TIPE_FILE` varchar(255) default NULL,
  `DIREKTORI_FILE` varchar(255) default NULL,
  PRIMARY KEY  (`KD_VERIFIKASI`),
  KEY `fk_verifikasi_surat_nip` (`NIP`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `oasys_akun_pegawai`
-- 
ALTER TABLE `oasys_akun_pegawai`
  ADD CONSTRAINT `fk_akun_pegawai` FOREIGN KEY (`NIP`) REFERENCES `oasys_pegawai` (`NIP`);

-- 
-- Constraints for table `oasys_arsip`
-- 
ALTER TABLE `oasys_arsip`
  ADD CONSTRAINT `fk_dokumen_jenis_dokumen` FOREIGN KEY (`KD_JENIS_DOKUMEN`) REFERENCES `oasys_jenis_dokumen` (`KD_JENIS_DOKUMEN`),
  ADD CONSTRAINT `fk_dokumen_nip` FOREIGN KEY (`NIP`) REFERENCES `oasys_pegawai` (`NIP`);

-- 
-- Constraints for table `oasys_disposisi`
-- 
ALTER TABLE `oasys_disposisi`
  ADD CONSTRAINT `fk_disposisi` FOREIGN KEY (`NIP`) REFERENCES `oasys_pegawai` (`NIP`);

-- 
-- Constraints for table `oasys_email_konsep_surat_keluar_eksternal`
-- 
ALTER TABLE `oasys_email_konsep_surat_keluar_eksternal`
  ADD CONSTRAINT `fk_email_konsep_surat_keluar_eksternal` FOREIGN KEY (`KD_SURAT`) REFERENCES `oasys_konsep_surat_keluar_eksternal` (`KD_SURAT`);

-- 
-- Constraints for table `oasys_email_surat_keluar_eksternal`
-- 
ALTER TABLE `oasys_email_surat_keluar_eksternal`
  ADD CONSTRAINT `fk_email_surat_keluar_eksternal_kd_surat` FOREIGN KEY (`KD_SURAT`) REFERENCES `oasys_surat_keluar_eksternal` (`KD_SURAT`);

-- 
-- Constraints for table `oasys_jabatan_struktural`
-- 
ALTER TABLE `oasys_jabatan_struktural`
  ADD CONSTRAINT `fk_jabatan_struktural` FOREIGN KEY (`KD_INSTITUSI`) REFERENCES `oasys_institusi` (`KD_INSTITUSI`);

-- 
-- Constraints for table `oasys_jabatan_struktural_pegawai`
-- 
ALTER TABLE `oasys_jabatan_struktural_pegawai`
  ADD CONSTRAINT `fk_jabatan_struktural_pegawai_js` FOREIGN KEY (`KD_JS`, `KD_UNIT`, `UNIT`) REFERENCES `oasys_jabatan_struktural` (`KD_JS`, `KD_UNIT`, `UNIT`),
  ADD CONSTRAINT `fk_jabatan_struktural_pegawai_nip` FOREIGN KEY (`NIP`) REFERENCES `oasys_pegawai` (`NIP`);

-- 
-- Constraints for table `oasys_kategori`
-- 
ALTER TABLE `oasys_kategori`
  ADD CONSTRAINT `fk_kategori` FOREIGN KEY (`KD_BIDANG`) REFERENCES `oasys_bidang` (`KD_BIDANG`);

-- 
-- Constraints for table `oasys_kepada_disposisi`
-- 
ALTER TABLE `oasys_kepada_disposisi`
  ADD CONSTRAINT `fk_kepada_disposisi_kd_disposisi` FOREIGN KEY (`KD_DISPOSISI`) REFERENCES `oasys_disposisi` (`KD_DISPOSISI`),
  ADD CONSTRAINT `fk_kepada_disposisi_kd_status` FOREIGN KEY (`KD_STATUS`) REFERENCES `oasys_status_surat` (`KD_STATUS`);

-- 
-- Constraints for table `oasys_kepada_konsep_surat_internal`
-- 
ALTER TABLE `oasys_kepada_konsep_surat_internal`
  ADD CONSTRAINT `fk_kepada_konsep_surat_internal` FOREIGN KEY (`KD_SURAT`) REFERENCES `oasys_konsep_surat_internal` (`KD_SURAT`);

-- 
-- Constraints for table `oasys_kepada_konsep_surat_keluar_eksternal`
-- 
ALTER TABLE `oasys_kepada_konsep_surat_keluar_eksternal`
  ADD CONSTRAINT `fk_kepada_konsep_surat_keluar_eksternal` FOREIGN KEY (`KD_SURAT`) REFERENCES `oasys_konsep_surat_keluar_eksternal` (`KD_SURAT`);

-- 
-- Constraints for table `oasys_kepada_surat_internal`
-- 
ALTER TABLE `oasys_kepada_surat_internal`
  ADD CONSTRAINT `fk_kepada_surat_internal_kd_status` FOREIGN KEY (`KD_STATUS`) REFERENCES `oasys_status_surat` (`KD_STATUS`),
  ADD CONSTRAINT `fk_kepada_surat_internal_kd_surat` FOREIGN KEY (`KD_SURAT`) REFERENCES `oasys_surat_internal` (`KD_SURAT`);

-- 
-- Constraints for table `oasys_kepada_surat_keluar_eksternal`
-- 
ALTER TABLE `oasys_kepada_surat_keluar_eksternal`
  ADD CONSTRAINT `fk_kepada_surat_keluar_eksternal_kd_surat` FOREIGN KEY (`KD_SURAT`) REFERENCES `oasys_surat_keluar_eksternal` (`KD_SURAT`);

-- 
-- Constraints for table `oasys_kepada_surat_masuk_eksternal`
-- 
ALTER TABLE `oasys_kepada_surat_masuk_eksternal`
  ADD CONSTRAINT `fk_kepada_surat_masuk_eksternal_kd_status` FOREIGN KEY (`KD_STATUS`) REFERENCES `oasys_status_surat` (`KD_STATUS`),
  ADD CONSTRAINT `fk_kepada_surat_masuk_eksternal_kd_surat` FOREIGN KEY (`KD_SURAT`) REFERENCES `oasys_surat_masuk_eksternal` (`KD_SURAT`);

-- 
-- Constraints for table `oasys_kepada_verifikasi`
-- 
ALTER TABLE `oasys_kepada_verifikasi`
  ADD CONSTRAINT `fk_kepada_verifikasi_kd_status` FOREIGN KEY (`KD_STATUS`) REFERENCES `oasys_status_surat` (`KD_STATUS`),
  ADD CONSTRAINT `fk_kepada_verifikasi_kd_verifikasi` FOREIGN KEY (`KD_VERIFIKASI`) REFERENCES `oasys_verifikasi` (`KD_VERIFIKASI`);

-- 
-- Constraints for table `oasys_klasifikasi`
-- 
ALTER TABLE `oasys_klasifikasi`
  ADD CONSTRAINT `fk_klasifikasi` FOREIGN KEY (`KATEGORI`) REFERENCES `oasys_kategori` (`KATEGORI`);

-- 
-- Constraints for table `oasys_konsep_surat_internal`
-- 
ALTER TABLE `oasys_konsep_surat_internal`
  ADD CONSTRAINT `fk_konsep_surat_internal_nip` FOREIGN KEY (`NIP`) REFERENCES `oasys_pegawai` (`NIP`);

-- 
-- Constraints for table `oasys_konsep_surat_keluar_eksternal`
-- 
ALTER TABLE `oasys_konsep_surat_keluar_eksternal`
  ADD CONSTRAINT `fk_konsep_surat_keluar_eksternal_nip` FOREIGN KEY (`NIP`) REFERENCES `oasys_pegawai` (`NIP`);

-- 
-- Constraints for table `oasys_letak_arsip`
-- 
ALTER TABLE `oasys_letak_arsip`
  ADD CONSTRAINT `fk_letak_dokumen` FOREIGN KEY (`KD_ARSIP`) REFERENCES `oasys_arsip` (`KD_ARSIP`);

-- 
-- Constraints for table `oasys_surat_internal`
-- 
ALTER TABLE `oasys_surat_internal`
  ADD CONSTRAINT `fk_surat_internal_nip` FOREIGN KEY (`NIP`) REFERENCES `oasys_pegawai` (`NIP`);

-- 
-- Constraints for table `oasys_surat_keluar_eksternal`
-- 
ALTER TABLE `oasys_surat_keluar_eksternal`
  ADD CONSTRAINT `fk_surat_keluar_eksternal_nip` FOREIGN KEY (`NIP`) REFERENCES `oasys_pegawai` (`NIP`);

-- 
-- Constraints for table `oasys_surat_masuk_eksternal`
-- 
ALTER TABLE `oasys_surat_masuk_eksternal`
  ADD CONSTRAINT `fk_surat_masuk_eksternal_nip` FOREIGN KEY (`NIP`) REFERENCES `oasys_pegawai` (`NIP`);

-- 
-- Constraints for table `oasys_tembusan_konsep_surat_internal`
-- 
ALTER TABLE `oasys_tembusan_konsep_surat_internal`
  ADD CONSTRAINT `fk_tembusan_konsep_surat_internal` FOREIGN KEY (`KD_SURAT`) REFERENCES `oasys_konsep_surat_internal` (`KD_SURAT`);

-- 
-- Constraints for table `oasys_tembusan_konsep_surat_keluar_eksternal`
-- 
ALTER TABLE `oasys_tembusan_konsep_surat_keluar_eksternal`
  ADD CONSTRAINT `fk_tembusan_konsep_surat_keluar_eksternal` FOREIGN KEY (`KD_SURAT`) REFERENCES `oasys_konsep_surat_keluar_eksternal` (`KD_SURAT`);

-- 
-- Constraints for table `oasys_tembusan_surat_internal`
-- 
ALTER TABLE `oasys_tembusan_surat_internal`
  ADD CONSTRAINT `fk_tembusan_surat_internal_kd_status` FOREIGN KEY (`KD_STATUS`) REFERENCES `oasys_status_surat` (`KD_STATUS`),
  ADD CONSTRAINT `fk_tembusan_surat_internal_kd_surat` FOREIGN KEY (`KD_SURAT`) REFERENCES `oasys_surat_internal` (`KD_SURAT`);

-- 
-- Constraints for table `oasys_tembusan_surat_keluar_eksternal`
-- 
ALTER TABLE `oasys_tembusan_surat_keluar_eksternal`
  ADD CONSTRAINT `fk_tembusan_surat_keluar_eksternal_kd_surat` FOREIGN KEY (`KD_SURAT`) REFERENCES `oasys_surat_keluar_eksternal` (`KD_SURAT`);

-- 
-- Constraints for table `oasys_tembusan_surat_masuk_eksternal`
-- 
ALTER TABLE `oasys_tembusan_surat_masuk_eksternal`
  ADD CONSTRAINT `fk_tembusan_surat_masuk_eksternal_kd_status` FOREIGN KEY (`KD_STATUS`) REFERENCES `oasys_status_surat` (`KD_STATUS`),
  ADD CONSTRAINT `fk_tembusan_surat_masuk_eksternal_kd_surat` FOREIGN KEY (`KD_SURAT`) REFERENCES `oasys_surat_masuk_eksternal` (`KD_SURAT`);

-- 
-- Constraints for table `oasys_verifikasi`
-- 
ALTER TABLE `oasys_verifikasi`
  ADD CONSTRAINT `fk_verifikasi_surat_nip` FOREIGN KEY (`NIP`) REFERENCES `oasys_pegawai` (`NIP`);
