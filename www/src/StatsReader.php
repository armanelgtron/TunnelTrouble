<?php
class StatsReader
{
	private string $file;
	private /*?resource*/ $f;
	private int $linenum; 
	
	protected ?string $currline;
	
	function __construct($file)
	{
		$this->file = $file;
		$f = fopen($this->file, "r");
		$this->f = $f?$f:null;
		$this->linenum = 0;
		$this->currline = null;
	}
	
	function __destruct()
	{
		if( $this->isOpen() )
			fclose($this->f);
		$this->f = null;
	}
	
	static function fromMap($name) //! open file by map name
	{
		return new self(getMapRankPath($name));
	}
	
	function isOpen()
	{
		return (bool)($this->f);
	}
	
	function next() //! go forward a line
	{
		if(!$this->f) return false;
		
		// read, skipping blank lines
		do { $line = fgets($this->f); }
		while( $line === "" );
		
		if($line !== false)
		{
			$this->linenum++;
			$this->currline = rtrim($line);
			return true;
		}
		
		return false;
	}
	function prev() //! go back a line
	{
		if( $this->getLine() <= 1 )
			return false;
		
		// okay, not the most efficient way to go back right now...
		// but these files shouldn't be too large anyway.
		$this->set( $this->get()-1 );
	}
	
	function get() //! get current line number
	{
		return $this->linenum;
	}
	function set($num) //! jump to a line number
	{
		$diff = $num - $this->linenum;
		if( $diff < 0 )
		{
			fseek($this->f, 0);
			$diff = $num;
		}
		# read until we're at the right line or we reach the end
		while( (--$diff) > 0 && $this->next() );
		# return whether we made it to the right line
		return( $this->linenum == $num );
	}
	
	function read() { return $this->currline; }
	
	
	// functions to get information about the current line
	// this can be adapted for different formats of ranks files
	function hasFinished()
	{
		return( $this->getTime() != -1 );
	}
	function getRank() //! get the rank number, or null if unfinished
	{
		if( !$this->hasFinished() )
			return null;
		
		return $this->linenum;
	}
	function getTime() //! get the amount of time it took to cross the finish line
	{
		return doubleval(substr($this->currline, strpos($this->currline, " ")));
	}
	function getUser() //! get the player who finished the map
	{
		return substr($this->currline, 0, strpos($this->currline, " "));
	}
	function getPlayer() { return $this->getUser(); }
	function getTimesFinished() //! get the number of times the player finished the map
	{
		return intval(substr($this->currline, strpos($this->currline, " ", strpos($this->currline, " ")+1)));
	}
	function getRealTime() //! get a unix timestamp of when the map was finished
	{
		$space1 = strpos($this->currline, " ");
		$space2 = strpos($this->currline, " ", $space1+1);
		$space3 = strpos($this->currline, " ", $space2+1);
		return intval(substr($this->currline, $space3));
	}
	function getAvgSpeed() //! get the average speed
	{
		// okay, this stats format doesn't support this
		return 0.;
	}
}
