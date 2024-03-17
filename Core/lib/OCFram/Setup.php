<?php

	error_reporting(-1);
	ini_set('display_errors', 'On');

	$link = mysqli_connect('localhost', 'root', '', 'mysql');
	if (!$link) {
		die('Connexion impossible : ' . mysqli_error($link));
	}

	$sql = 'CREATE DATABASE IF NOT EXISTS site_domain';
	if (mysqli_query($link,$sql)) {
		$sql = "GRANT ALL ON `site_domain`.* TO 'admin'@'localhost' IDENTIFIED BY 'ExN754Aodq' ";
		if (mysqli_query($link,$sql)) {
		} else {
			echo 'Erreur when creating user : ' . mysqli_error($link) . "\n";
		}
	
	} else {
		echo 'Erreur when creating database : ' . mysqli_error($link) . "\n";
	}


	if ($handleApplications = opendir('../App/')) { 
		while (false !== ($Application = readdir($handleApplications))) { 
			if ($Application != "." && $Application != "..") {
				if ( $handleModule = opendir('../App/' . $Application .'/Modules/')) { 
					while (false !== ($Module = readdir($handleModule))) { 
						if ($Module != "." && $Module != "..") {
							require( '../App/' . $Application .'/Modules/' . $Module . '/Setup.php'); 
						}
					}
				}
				closedir($handleModule); 
			}
		}
	}
	closedir($handleApplications); 
