<?php
/**
 * class.eventMgr.php
 *
 * @package niftyrsvp
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
/**
 * Manages all functionality related to user-created events
 *
 * @package niftyrsvp
 * @version 0.9 beta
 */
class eventMgr extends classParent
{
	/**
	 * Database abstraction layer handle
	 *
	 * @var array
	 */
    protected $mdb2;

    /**
     * Array for site configuration settings held in the database
     *
     * @var array
     */
    public $config;

    /**
     * Constructor for the client
     *
     * @param array $mdb2
     */
    public function __construct($mdb2)
    {
        $this->db = $mdb2;
    }

	public function createEvent($args)
	{
		$e_url = $this->createEventUrl($args['e_name']);

		$nextId = $this->db->nextId(TABLE_EVENTS);
		if (PEAR::isError($nextId)) {
			throw new sqlException('Unable to get the next event sequence id. MDB2 says: ' . $nextId->getMessage(), 0);
		}

		$sql = 'INSERT INTO ' . TABLE_EVENTS . " (id, created, e_name, e_date_time, e_location, e_notes, e_url, e_event_viewed) VALUES($nextId,'{$this->date()}','{$args['e_name']}','{$args['e_date_time']}','{$args['e_location']}','{$args['e_notes']}','$e_url','no')";

		$res = $this->db->exec($sql);
        if (PEAR::isError($res)) {
        	throw new sqlException('Could not insert data for the new event. MDB2 says: ' . $res->getMessage(), 0);
        }

        return $e_url;
	}

	/**
	 * Creates an SEO-friendly, unique URL that is based on the event's name
	 *
	 * @param string $arg
	 */
	private function createEventUrl($arg)
	{
		//  Clean up the url and remove any characters no in [A-Za-z0-9_]
		$url = str_replace(' ','_',strtolower(trim($arg)));

		$pattern = "/[^A-Za-z0-9_]/";
		$replacement = '';
		$url = preg_replace($pattern,$replacement,$url);

		// remove common words
		$new_url = '';
		$commonWords = array('a','an','of','the','is','for','by','to');

		$exploded = explode('_',$url);
		foreach($exploded as $key => $val)
		{
			$word = preg_replace('/\b('.implode('|',$commonWords).')\b/','',$val);
			$new_url .= (strlen($word) > 0) ? $word . '_' : '';
		}

		$new_url = rtrim($new_url,'_');

		//  does this event url already exist?  If so, make it unique
		$match = false;

		$sql = 'SELECT e_url FROM ' . TABLE_EVENTS;

		$res = $this->db->query($sql);
        if (PEAR::isError($res)) {
        	throw new sqlException('Query for existing event URLS failed. MDB2 says: ' . $res->getMessage(), 0);
        }

        while($row = $res->fetchRow())
        {
        	if($new_url == $row['e_url'])
        	{
        		$match = true;
        		break;
        	}
        }

        if($match)
        {
        	//  append the unix time stamp
        	$new_url = $new_url . '_' . time();
        }

        return $new_url;
	}

	public function getDetails($id)
	{
		$sql = 'SELECT * FROM ' . TABLE_EVENTS . ' WHERE e_url=\''. $id . '\' LIMIT 1';

		$res = $this->db->query($sql);
        if (PEAR::isError($res)) {
         	throw new sqlException('Search for event details by URL failed. MDB2 says: ' . $res->getMessage(), 0);
        }

        while($row = $res->fetchRow())
        {
        	$details['id'] = $row['id'];
        	$details['e_name'] = $row['e_name'];
        	$details['e_date_time'] = $row['e_date_time'];
        	$details['e_location'] = $row['e_location'];
        	$details['e_notes'] = $row['e_notes'];
        	$details['e_event_viewed'] = $row['e_event_viewed'];
        }

        return $details;
	}

	public function registerAttendee($args)
	{
		$nextId = $this->db->nextId(TABLE_ATTENDEES);
		if (PEAR::isError($nextId)) {
			throw new sqlException('Unable to get the next attendee sequence id. MDB2 says: ' . $nextId->getMessage(), 0);
		}

		$attending = ($args['attending'] == 'yes') ? 1 : 0;

		$sql = 'INSERT INTO ' . TABLE_ATTENDEES . " (id,event_id,name,email,attending) VALUES($nextId,{$args['e_id']},'{$args['name']}','{$args['email']}','$attending')";

		$res = $this->db->exec($sql);
        if (PEAR::isError($res)) {
          	throw new sqlException('Could not register the attendee, query failed. MDB2 says: ' . $res->getMessage(), 0);
        }

        return true;
	}

	public function getUrlById($id)
	{
		$sql = 'SELECT e_url FROM ' . TABLE_EVENTS . ' WHERE id=\''. $id . '\' LIMIT 1';

		$res = $this->db->query($sql);
        if (PEAR::isError($res)) {
          	throw new sqlException('Search for an event by ID failed. MDB2 says: ' . $res->getMessage(), 0);
        }

        while($row = $res->fetchRow())
        {
        	$e_url = $row['e_url'];
        }

        return $e_url;
	}

	public function getResponders($id)
	{
		$sql = 'SELECT name,attending FROM ' . TABLE_ATTENDEES . ' WHERE event_id=\''. $id . '\'';

		$res = $this->db->query($sql);
        if (PEAR::isError($res)) {
          	throw new sqlException('Search for attendees failed. MDB2 says: ' . $res->getMessage(), 0);
        }

        $responders = array();

        while($row = $res->fetchRow())
        {
        	if($row['attending'] == 1)
        	{
        		$responders['attending'][] = $row['name'];
        	}
        	else
        	{
        		$responders['not_attending'][] = $row['name'];
        	}
        }

        return $responders;
	}

	public function eventViewed($id)
	{
		$sql = 'UPDATE ' . TABLE_EVENTS . ' SET e_event_viewed=\'yes\' WHERE id=\'' . $id . '\' LIMIT 1';

		$res = $this->db->exec($sql);
        if (PEAR::isError($res)) {
          	throw new sqlException('Could not set the event details as being viewed. MDB2 says: ' . $res->getMessage(), 0);
        }

        return true;
	}
}
?>