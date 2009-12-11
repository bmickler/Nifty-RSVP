<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="MSSmartTagsPreventParsing" content="true" />
	<meta name="author" content="Bryce Mickler" />

	<link rel="stylesheet" type="text/css" href="{$CSS_PATH}blueprint/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="{$CSS_PATH}blueprint/print.css"  media="print" />
	<!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="{$CSS_PATH}blueprint/ie.css" media="screen, projection" /><![endif]-->
    <link rel="stylesheet" href="{$CSS_PATH}blueprint/plugins/fancy-type/screen.css" type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="{$CSS_PATH}style.css" type="text/css" media="screen, projection" />

    <title>{$HTML_TITLE}</title>
</head>
<body>
<div class="container">

	<div id="header" class="span-24 header">&nbsp;</div>

	<hr/>

	<div id="subheader" class="span-24">
		<h2 class="alt">Create Your Event</h2>
	</div>

	<hr/>

	<div class="span-12">

		<form id="form" action="index.php" method="post">
		
		<p>
			<label for="e_name">Event Name</label><br/>
			<input type="text" name="e_name" id="e_name" class="title" maxlength="255" />
		</p>
		<p>
			<label for="e_date_time">Event Date &amp; Time</label><br/>
			<input type="text" name="e_date_time" id="e_date_time" class="title" maxlength="255" />
		</p>
		<p>
			<label for="e_location">Location</label><br/>
			<input type="text" name="e_location" id="e_location" class="title" maxlength="255" />
		</p>

	</div>
	
	<div class="span-12 last">
	
		<p>
			<label for="e_notes">Description<i>(Max 400 characters)</i></label><br/>
			<textarea name="e_notes" id="e_notes" rows="3" cols="20"></textarea>
		</p>
		<p>
			<input type="submit" name="submit" id="submit" value="Create Event" />
		</p>
		
		</form>

	</div>
{$FOOTER}