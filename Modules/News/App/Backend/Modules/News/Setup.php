<?php
	
	$link = mysqli_connect('localhost', 'root', '', 'site_domain');
	if (!$link) {
		die('Connexion impossible : ' . mysqli_error($link));
	}

	