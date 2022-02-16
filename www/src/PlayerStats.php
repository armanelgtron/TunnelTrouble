<?php
class PlayerStats
{
	static array $players = [];
	static function newPlayer($name)
	{
		array_push(self::$players, $s=(new PlayerStats($name)));
		return $s;
	}
	static function readPlayerStats($toGet=false)
	{
		global $saveto, $rankfiles;
		if(!$toGet)
		{
			$toGet = Array();
			foreach(self::$players as $p)
			{
				if(!$p->hasStats)
				{
					array_push($toGet, $p);
				}
			}
		}
		else
		{
			foreach($toGet as $p)
			{
				if(!($p instanceof PlayerStats))
				{
					throw new TypeError("player not an instance of PlayerStats");
				}
			}
		}
		
		foreach($toGet as $s)
		{
			$s->rec = array();
			$s->notraced = array();
		}
		
		$x=0;$rankerdiv=0;foreach($rankfiles as $file)
		{
			$map = basename($file, ".aamap.xml.txt");
			$stats = new StatsReader($file);
			$r = $stats;
			foreach($toGet as $s)
			{
				while( $stats->next() )
				{
					if( $r->hasFinished() && $r->getUser() == $s->name )
					{
						$x = $r->getRank();
						
						// rank info
						if($x <= 10) $s->topten++;
						if($x <= 3) $s->topthree++;
						if($x == 1) $s->top1++;
						if($x == 2) $s->top2++;
						if($x == 3) $s->top3++;
						
						$s->played++;
						
						$s->ranker += $x;
						$s->rec[$map] = $x-1;
						
						if(isset($s->ranks[$x])) $s->ranks[$x] += 1;
						else $s->ranks[$x] = 1;
					}
				}
				if(!isset($s->rec[$map])) {$s->notraced[] = $map; $s->notranks += $x;}
				$stats->set(0); // rewind to beginning
			}
			unset($stats, $r);
		}
		foreach($toGet as $s)
		{
			ksort($s->ranks);
			$s->ranker /= $s->played;
		}
	}
	static function getPlayersBy($param, $rev=false)
	{
		$players = [];
		assert( !isset(self::$players[0]) || isset(self::$players[0]->$param) );
		foreach(self::$players as $p)
		{
			array_push($players, $p);
		}
		usort($players, function($a, $b) use ( $param, $rev )
		{
			if( $a->$param == $b->$param )
			{
				return 0;
			}
			if($rev) return ( ( $a->$param ) < ( $b->$param ) )?-1:1;
			else return ( ( $a->$param ) > ( $b->$param ) )?-1:1;
		});
		return $players;
	}
	static function getPlayersIf($param)
	{
		$players = [];
		assert( !isset(self::$players[0]) || isset(self::$players[0]->$param) );
		foreach(self::$players as $p)
		{
			if( $p->$param )
			{
				array_push($players, $p);
			}
		}
		return $players;
	}
	
	
	public string $name;
	
	private bool $hasStats;
	
	public int $topten, $topthree;
	public int $top1, $top2, $top3;
	public int $played;
	public float $ranker;
	
	public array $rec;
	public array $notraced;
	
	public int $notranks;
	
	function __construct($name)
	{
		$this->name = $name;
		
		$this->topten = $this->topthree = 0;
		$this->top1 = $this->top2 = $this->top3 = 0;
		$this->played = $this->notranks = 0;
		$this->ranker = 0.;
		
		$this->rec = array();
		
		$this->hasStats = false;
	}
}
