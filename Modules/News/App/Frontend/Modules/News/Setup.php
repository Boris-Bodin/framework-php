<?php
	
	$link = mysqli_connect('localhost', 'root', '', 'site_domain');
	if (!$link) {
		die('Connexion impossible : ' . mysqli_error($link));
	}

	$sql = 'CREATE TABLE IF NOT EXISTS `news` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `auteur` varchar(30) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `contenu` text NOT NULL,
  `dateAjout` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModif` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;';

	if (mysqli_query($link,$sql)) {
	} else {
		die('Setup impossible : ' . mysqli_error($link));
	}
	
	$sql = 'CREATE TABLE IF NOT EXISTS `news_comments` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `news` smallint(6) NOT NULL,
  `auteur` varchar(50) NOT NULL,
  `contenu` text NOT NULL,
  `date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;';
	

	if (mysqli_query($link,$sql)) {
	} else {
		die('Setup impossible : ' . mysqli_error($link));
	}
	