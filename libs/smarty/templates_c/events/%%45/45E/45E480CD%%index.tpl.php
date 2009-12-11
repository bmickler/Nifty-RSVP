<?php /* Smarty version 2.6.26, created on 2009-12-09 20:49:19
         compiled from index.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="MSSmartTagsPreventParsing" content="true" />
	<meta name="author" content="Bryce Mickler" />

	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['CSS_PATH']; ?>
blueprint/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['CSS_PATH']; ?>
blueprint/print.css"  media="print" />
	<!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['CSS_PATH']; ?>
blueprint/ie.css" media="screen, projection" /><![endif]-->
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['CSS_PATH']; ?>
blueprint/plugins/fancy-type/screen.css" type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['CSS_PATH']; ?>
style.css" type="text/css" media="screen, projection" />

    <title><?php echo $this->_tpl_vars['HTML_TITLE']; ?>
</title>
</head>
<body>
<div class="container">

	<div id="header" class="span-24 header">&nbsp;</div>

	<hr/>

    <?php if ($this->_tpl_vars['EVENT_CREATED'] == 'yes'): ?>

	<div class="span-12 success">

		<h2>Your event has been created!</h2>

		<p>Congratulations.  Now you've got to let everyone know about your event so they can RSVP.  Here's how:</p>

		<ul>
			<li>1.  Copy this page's URL.</li>
			<li>2.  Email it to those you wish to invite.</li>
			<li>3.  Ask them to visit the event's page and RSVP.</li>
			<li>4.  Don't forget to RSVP yourself by filling out the form below.</li>
		</ul>

		<p>That's it.  Thanks for using NiftyRSVP.</p>

	</div>
	
	<div class="span-12">&nbsp;</div>
	
	<hr/>
		
    <?php endif; ?>
	
	<div class="span-9">
	
		<h3 class="caps">When</h3>
		<p class="box quiet"><?php echo $this->_tpl_vars['EVENT_DATE_TIME']; ?>
</p>
	
		<h3 class="caps">Where</h3>
		<p class="box quiet"><?php echo $this->_tpl_vars['EVENT_LOCATION']; ?>
</p>
	
		<h3 class="caps">Notes</h3>
		<p class="box quiet"><?php echo $this->_tpl_vars['EVENT_NOTES']; ?>
</p>
		
	</div>
	
	<div class="span-3">&nbsp;</div>
	
	<div class="span-12 last">
	
		<h2 class="alt">RSVP</h2>
		
		<p>
			<form id="form" action="index.php" method="post">
			<input type="hidden" name="e_id" value="<?php echo $this->_tpl_vars['EVENT_ID']; ?>
" />
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
		
	<div class="span-12">

		<h2 class="alt">Attending</h2>

		<?php $_from = $this->_tpl_vars['EVENT_ATTENDEES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['attending'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attending']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
        $this->_foreach['attending']['iteration']++;
?>

			<h3 class="loud"><?php echo $this->_tpl_vars['i']; ?>
</h3>
			
		<?php endforeach; endif; unset($_from); ?>

	</div>

	<div class="span-12 last">

		<h2 class="alt">Not Attending</h2>

		<?php $_from = $this->_tpl_vars['EVENT_NON_ATTENDEES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['not_attending'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['not_attending']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
        $this->_foreach['not_attending']['iteration']++;
?>

			<h3 class="loud"><?php echo $this->_tpl_vars['i']; ?>
</h3>
			
		<?php endforeach; endif; unset($_from); ?>

	</div>
		
<?php echo $this->_tpl_vars['FOOTER']; ?>