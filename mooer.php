<?php

// (B) ACCEPTED FILE TYPES & SIZE
$accept = ["mo"]; // ALL LOWER CASE
$maxSize = 10000; // 10 KB
$upExt = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

if (isset($_POST["submit"])) {
	// ERROR - NO FILE UPLOADED
	if (!file_exists($_FILES["file"]['tmp_name']) ) { 
		echo "<script>
						function errorMessageOne(){
						document.getElementById('formError').innerHTML +='No file selected.';
						}
						window.addEventListener('load', function() {
							errorMessageOne();
						})
						
			 </script>"; 
		}
	// CHECK FILE EXTENSION
	elseif (!in_array($upExt, $accept)){
		echo "<script>
						function errorMessageOne(){
						document.getElementById('formError').innerHTML +='Wrong file type.';
						}
						window.addEventListener('load', function() {
							errorMessageOne();
						})
						
			 </script>"; 
	}
	// CHECK FILE SIZE
	elseif ($_FILES["file"]["size"] > $maxSize){
		echo "<script>
						function errorMessageOne(){
						document.getElementById('formError').innerHTML +='File too big.';
						}
						window.addEventListener('load', function() {
							errorMessageOne();
						})
						
			 </script>"; 
	}
	else {
    $content = file_get_contents($_FILES["file"]["tmp_name"]);
    $array = unpack("C*", $content);
//print_r($array);
    $effectModule = [];
//FX/COMP 541 - 548
    $effectModule['FX/COMP']['TYPE'] = $array[541] - 1;
    $effectModule['FX/COMP']['SWITCH'] = $array[542];
    $effectModule['FX/COMP']['Data']['ATTACK'] = $array[543];
    $effectModule['FX/COMP']['Data']['THRES'] = $array[544];
    $effectModule['FX/COMP']['Data']['RATIO'] = $array[545];
    $effectModule['FX/COMP']['Data']['LEVEL'] = $array[546];
//DS/OD 549 - 556
    $effectModule['DS/OD']['TYPE'] = $array[549] - 1;
    $effectModule['DS/OD']['SWITCH'] = $array[542];
    $effectModule['DS/OD']['Data']['VOLUME'] = $array[551];
    $effectModule['DS/OD']['Data']['TONE'] = $array[552];
    $effectModule['DS/OD']['Data']['GAIN'] = $array[553];
//AMP 557 - 564
    $effectModule['AMP']['TYPE'] = $array[557] - 1;
    $effectModule['AMP']['SWITCH'] = $array[558];
    $effectModule['AMP']['Data']['GAIN'] = $array[559];
    $effectModule['AMP']['Data']['BASS'] = $array[560];
    $effectModule['AMP']['Data']['MID'] = $array[561];
    $effectModule['AMP']['Data']['TREBLE'] = $array[562];
    $effectModule['AMP']['Data']['PRES'] = $array[563];
    $effectModule['AMP']['Data']['MST'] = $array[564];
//CAB 565 - 572
    $effectModule['CAB']['TYPE'] = $array[565] - 1;
    $effectModule['CAB']['SWITCH'] = $array[566];
    $effectModule['CAB']['Data']['TUBE'] = $array[559];
    $effectModule['CAB']['Data']['MIC'] = $array[567];
    $effectModule['CAB']['Data']['CENTER'] = $array[568];
    $effectModule['CAB']['Data']['DISTANCE'] = $array[569];
//NS GATE 573 - 580
    $effectModule['NS GATE']['TYPE'] = $array[573] - 1;
    $effectModule['NS GATE']['SWITCH'] = $array[574];
    $effectModule['NS GATE']['Data']['ATTACK'] = $array[575];
    $effectModule['NS GATE']['Data']['RELEASE'] = $array[576];
    $effectModule['NS GATE']['Data']['THRES'] = $array[577];
//DELAY 597
    $effectModule['DELAY']['TYPE'] = $array[597] - 1;
    $effectModule['DELAY']['SWITCH'] = $array[598];
    $effectModule['DELAY']['Data']['LEVEL'] = $array[599];
    $effectModule['DELAY']['Data']['SUB-D'] = $array[604];
    $effectModule['DELAY']['Data']['TIME'] = @array_shift(unpack('S*', $content[862] . $content[863]));
    $effectModule['DELAY']['Data']['FEEDBACK'] = $array[600];
//REVERB 605
    $effectModule['REVERB']['TYPE'] = $array[605] - 1;
    $effectModule['REVERB']['SWITCH'] = $array[606];
    $effectModule['REVERB']['Data']['PRE DELAY'] = $array[607];
    $effectModule['REVERB']['Data']['LEVEL'] = $array[608];
    $effectModule['REVERB']['Data']['DECAY'] = $array[609];
    $effectModule['REVERB']['Data']['TONE'] = $array[610];
//EQ 581
    $effectModule['EQ']['TYPE'] = $array[581] - 1;
    $effectModule['EQ']['SWITCH'] = $array[582];
    if ($effectModule['EQ']['TYPE'] == 1) {
        $effectModule['EQ']['Data']['80Hz'] = 16 + ($array[583] - 12);
        $effectModule['EQ']['Data']['240Hz'] = 16 + ($array[584] - 12);
        $effectModule['EQ']['Data']['750Hz'] = 16 + ($array[585] - 12);
        $effectModule['EQ']['Data']['2.2KHz'] = 16 + ($array[586] - 12);
        $effectModule['EQ']['Data']['6.6KHz'] = 16 + ($array[587] - 12);
    } elseif ($effectModule['EQ']['TYPE'] == 2) {
        $effectModule['EQ']['Data']['100Hz'] = 16 + ($array[583] - 12);
        $effectModule['EQ']['Data']['200Hz'] = 16 + ($array[584] - 12);
        $effectModule['EQ']['Data']['400Hz'] = 16 + ($array[585] - 12);
        $effectModule['EQ']['Data']['800Hz'] = 16 + ($array[586] - 12);
        $effectModule['EQ']['Data']['1.6KHz'] = 16 + ($array[587] - 12);
        $effectModule['EQ']['Data']['3.2KHz'] = 16 + ($array[588] - 12);
    }
//MOD 589 - 596
    $effectModule['MOD']['TYPE'] = $array[589] - 1;
    $effectModule['MOD']['SWITCH'] = $array[590];
    $effectModule['MOD']['Data']['LEVEL'] = $array[592];
    $effectModule['MOD']['Data']['DEPTH'] = $array[593];
    $effectModule['MOD']['Data']['RATE'] = $array[591];

    $presetName = ucwords(preg_replace('/[^A-Za-z0-9\-]/', '', (trim(substr($content, 524, 16)))));
    $fileInfo = [
        'app' => 'GE150 Edit',
        'app_version' => 'V1.1.0',
        'device' => 'MOOER GE150',
        'preset_name' => $presetName,
        'schema' => 'GE150 Preset',
        'device_version' => 'V1.1.0',
    ];

		 
    header('Content-disposition: attachment; filename=' . $presetName . '.mo');
    header('Content-Type: application/json');
    echo json_encode([
        'effectModule' => $effectModule,
        'Exp' => [
            'VOL_MIN' => 0,
            'FUN_SWITCH' => 0,
            'VOL_MAX' => 100,
            'PARA_CTRL' => 1,
            'MODULE_CTRL' => 0,
            'VOL_SWITCH' => 0,
        ],
        'fileInfo' => $fileInfo,
    ]);
		
    exit();
}
}
?>

<!doctype html>
<html lang="en">
<head>
		<meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Convert GE200 Presets to GE150</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,600;1,600&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,300;0,500;0,600;0,700;1,300;1,500;1,600;1,700&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400&amp;display=swap" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<style>.formConverter button {margin-top:0px !important;}</style>
   
</head>
   <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
            <div class="container px-5">
                <a class="navbar-brand fw-bold" href="#page-top"><image src="assets/img/logo.png" class="logoPrimary"/></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="bi-list"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">	
                    <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                        <li class="nav-item" style="display:none;"><a class="nav-link me-lg-3" href="#mooerFormConverter">Convert</a></li>
                    </ul>
					
					<button class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0" data-bs-toggle="modal" data-bs-target="#importPluginModal">
							<span class="d-flex align-items-center">
								<i class="bi-person-circle me-2"></i>
								<span class="small">How to Import GE150 Presets &amp; IRs</span>
							</span>
					</button>
                </div>
            </div>
        </nav>
  
        <!-- SECTION MOOER CONVERTER FORM -->
        <header id="mooerFormConverter" class="masthead formConverter text-center bg-gradient-primary-to-secondary">
            <div class="container px-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-xl-8">
						<div class="h2 fs-1 text-white mb-4">Mooer Multieffect Guitar Preset Converter</div> 
                        <p class="lead textWhite  textLineHeight">Convert GE200 presets to make them usable with the GE150. Just select a GE200 preset .mo file and hit the convert button!</p>
						<br />
						<div class="container-fluid">
							<div id="formError"></div>
						  <form class="form-inline row g-3 d-flex justify-content-center" action="" method="post" enctype="multipart/form-data">
							<div class="col-auto">
								<input class="form-control" type="file" name="file" id="formFile">
							</div>
							<div class="col-auto">						
								<button type="submit" value="Submit" name="submit" class="btn btn-warning m-2" onclick="clearError()">Convert</button>
							</div>
						  </form>
						</div>
						<br />
						<br />
                    </div>
                </div>
            </div>
        </header>

        <!-- SECTION CREDITS -->
        <header id="formCredits" class="text-center">
            <div class="container px-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-xl-12">
						<br />
						<p>
							Beautification &amp; User Experience by <a href="https://github.com/sidekickDan" target="_blank"><img src="assets/img/icon_github.png" /> sidekickDan</a> of <a href="http://uxredesigner.com" target="_blank">UXRedesigner</a>. 
							PHP Functionality Created by <a href="https://github.com/sonnm" target="_blank"><img src="assets/img/icon_github.png" /> sonnm</a>
						</p>
                    </div>
                </div>
            </div>
        </header>
		
		<!-- SECTION HOW TO IMPORT PLUGIN MODAL -->
        <div class="modal fade" id="importPluginModal" tabindex="-1" aria-labelledby="importPluginModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width:99% !important;margin:20px;">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary-to-secondary p-4">
                        <h5 class="modal-title font-alt text-white" id="feedbackModalLabel">How to Import Presets to the GE150</h5>
                        <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body border-0 p-4">
       
						<div class="container-fluid">
							<div class="row gx-5 align-items-center justify-content-center justify-content-lg-between">
								<h2>How to Import Presets to the GE150</h2>
								<h4>There are just a few easy steps to import your presets into the GE150.</h4>
								<ul style="margin-left:20px;">
									<li>Plug in your GE150 to power.</li>
									<li>Plug in your GE150 to your laptop via usb.</li>
									<li>Open the Mooer Studio for GE150 software on your computer.</li>
									<li>Find the COMPUTER Panel and right-click anywhere in the empty area.</li>
									<li>Select "Add" and navigate to the .mo preset file and select it. (The software will automatically create a copy in the software's preset folder.)</li>
									<li>If the .mo preset file is compatible with your GE150, you should see the name of the preset now appear in the COMPUTER Panel.</li>
									<li>To import the preset to your device, just drag and drop the new preset over the top of one of the existing presets you see in the DEVICE Panel.</li>
									<li>Confirm your choice. The imported preset now should overwrite the factory preset used for that slot.</li>
								</ul>
								<br />
								<h2>How to Import CAB IR Files to the GE150</h2>
								<p>If you're looking to import a CAB IR file, this is slightly different but easier. (1) Select the CAB icon at the bottom of the interface. (2) Scroll to the bottom of the list found in the CAB Panel. You'll see some empty slots. (3) Then click the + icon to navigate to the IR file and import it.</p>
								<br />
								<img src="assets/img/UI_GE150.jpg" style="width:85%;height:auto;"/>
							</div>
						</div>
		

                    </div>
                </div>
            </div>
        </div>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<!-- Bootstrap core JS-->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
		<!-- Core theme JS-->
		<script src="js/scripts.js"></script>
		<!-- Clear any error messages on clicking submit button again -->	
		<script>
			function clearError(){
				document.getElementById('formError').innerHTML ='';
			}
		 </script>

</body>
</html>
