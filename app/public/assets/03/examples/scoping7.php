<?php

	error_reporting(E_ALL); // set error reporting on

	const HOST = 'http://www.myhost.com/';

	function absUrl(string $relUrl) {
		return HOST . $relUrl;
	}

	echo absUrl('files/uploads/me.jpg');