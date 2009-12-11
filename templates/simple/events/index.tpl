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

	<div id="header" class="span-24 header">{$EVENT_NAME}</div>

	<hr/>

    {if $EVENT_CREATED == 'yes'}

    <div class="span-4">&nbsp;</div>
	<div class="span-12 success last">

		<h2>Congratulations! Your event has been created</h2>

		<p>Now you've got to let everyone know about your event so they can RSVP.  Here's how:</p>

		<ul>
			<li>1.  Copy this page's URL.</li>
			<li>2.  Email it to those you wish to invite.</li>
			<li>3.  Ask them to visit the event's page and RSVP.</li>
			<li>4.  Don't forget to RSVP yourself by filling out the form below.</li>
		</ul>

		<p>That's it!  Thanks for using NiftyRSVP.</p>

	</div>

	<div class="span-12">&nbsp;</div>

	<hr/>

    {/if}

	<div class="span-9">

		<h3 class="caps">When</h3>
		<p class="box quiet">{$EVENT_DATE_TIME}</p>

		<h3 class="caps">Where</h3>
		<p class="box quiet">{$EVENT_LOCATION}</p>

		<h3 class="caps">Notes</h3>
		<p class="box quiet">{$EVENT_NOTES}</p>

	</div>

	<div class="span-3">&nbsp;</div>

	<div class="span-12 last">

		<h2 class="alt">RSVP</h2>

		<p>
			<form id="form" action="index.php" method="post">
			<input type="hidden" name="e_id" value="{$EVENT_ID}" />
			<label for="name">Your Name</label><br/>
			<input type="text" name="name" id="name" class="text" />
		</p>

		<p>
			<label for="email">Your Email Address</label><br/>
			<input type="text" name="email" id="email" class="text" />
		</p>

		<p>

			<label for="attending">Will you attend?</label><br/>
			<select name="attending" id="attending">
				<option value="" selected="selected">-- Select an option --</option>
				<option value=""></option>
				<option value="yes">YES, I will be attending!</option>
				<option value="no">NO, I will not attend.</option>
			</select>

		</p>

		<p>
			<input type="submit" name="submit" id="submit" />
			</form>
		</p>

	</div>

	<hr/>

	<div class="span-3">&nbsp;</div>
	<div class="span-9">

		<h2 class="alt">Attending({$EVENT_ATTENDING_COUNT})</h2>

		{foreach name=attending from=$EVENT_ATTENDEES key=k item=i}

			<h3 class="loud">{$i}</h3>

		{/foreach}

	</div>

	<div class="span-3">&nbsp;</div>
	<div class="span-9 last">

		<h2 class="alt">Not Attending ({$EVENT_NOT_ATTENDING_COUNT})</h2>

		{foreach name=not_attending from=$EVENT_NON_ATTENDEES key=k item=i}

			<h3 class="loud">{$i}</h3>

		{/foreach}

	</div>

{$FOOTER}