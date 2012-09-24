<?php
/*******************************************************************************
 * Copyright (c) iSpring Solutions, Inc. 
 * All rights reserved. This source code and the accompanying materials are made
 * available under the terms of the iSpring Public License v1.0 which accompanies
 * this distribution, and is available at:
 * http://www.ispringsolutions.com/legal/public-license-v10.html
 *
 *******************************************************************************/

	set_time_limit(0);
	
	echo getcwd() . "\n";
	//exit();

	$PPT_FILE = "./quicktour.ppt";

	$fs = new COM("iSpringAS3SDK.PresentationConverter.6");

	echo "Opening presentation\n";
	$fs->OpenPresentation($PPT_FILE);

	echo "Generating flash...\n";
	$fs->GenerateSolidPresentation();

	echo "Done\n";


	// Warning! When you don't need iSpring object it is necessary to set it to null
	// otherwise error will occur when PHP script finishes.
	$fs = null;

?>