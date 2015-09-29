<?php
    
class Fixture
{
    private $_db,
            $_data,
            $_teams;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function getMyTeams()
    {
        $teams = $this->_db->get('teams');

        if($teams->count())
        {
            return $teams->results();
        }

        return false;
    }

    public function getCompetitions()
    {
        $competitions = $this->_db->get('competitions');

        if($competitions->count())
        {
            return $competitions->results();
        }

        return false;
    }

    public function getOpponents()
    {
        $opponents = $this->_db->get('opponent');

        if($opponents->count())
        {
            return $opponents->results();
        }

        return false;
    }

    public function getLocations()
    {
        $locations = $this->_db->get('location');

        if($locations->count())
        {
            return $locations->results();
        }

        return false;
    }

    public function create($fields)
    {
        if(!$this->_db->insert('matches', $fields))
        {
            throw new Exception('Error creating fixture');
        }
    }

    public function delete($matchId)
    {
        $where =  array('MatchId', '=', $matchId);

        if(!$this->_db->delete('matches', $where))
        {
            throw new Exception('Error deleting fixture');
        }
    }

    public function getMatch($matchId)
    {
        if(!isset($matchId) && !strlen($matchId))
        {
            throw new Exception("Missing Parameter: MatchId");
        }

        $sql = "SELECT 
	                m.MatchId,
	                c.CompetitionName,
	                l.GroundName,
	                l.Town,
	                l.Postcode,
	                o.OpponentName,
	                m.Date,
                    m.KickOff,
	                m.Result,
	                m.Score,
	                IF(m.HomeGame, 'TRUE', 'FALSE') AS 'HomeGame',
                    t.Name
                FROM 
	                matches m 
                JOIN 
	                competitions c 
                ON
	                m.CompetitionId = c.CompetitionId
                JOIN 
	                location l 
                ON 
	                m.LocationId = l.LocationId 
                JOIN 
	                opponent o 
                ON 
	                m.OpponentId = o.OpponentId
                JOIN
	                teams t
                ON
	                m.teamId = t.teamId
                WHERE
                    m.MatchId = ?";
        
        $matchIdArray = array($matchId);
        $resultSet = $this->_db->query($sql, $matchIdArray);

        return $resultSet;

    }

    public function getAllMatches($teamId = null)
    {
        $sql = "SELECT 
	                m.MatchId,
	                c.CompetitionName,
	                l.GroundName,
	                l.Town,
	                l.Postcode,
	                o.OpponentName,
	                m.Date,
                    m.KickOff,
	                m.Result,
	                m.Score,
	                IF(m.HomeGame, 'TRUE', 'FALSE') AS 'HomeGame',
                    t.Name
                FROM 
	                matches m 
                JOIN 
	                competitions c 
                ON
	                m.CompetitionId = c.CompetitionId
                JOIN 
	                location l 
                ON 
	                m.LocationId = l.LocationId 
                JOIN 
	                opponent o 
                ON 
	                m.OpponentId = o.OpponentId
                JOIN
	                teams t
                ON
	                m.teamId = t.teamId";

        if(is_numeric($teamId) || strlen($teamId))
        {
            $sql .= " WHERE m.teamId = ?";
            $sql .= " ORDER BY Date ASC";
            $teamIdArray = array($teamId);

            $resultSet = $this->_db->query($sql, $teamIdArray);
            return($resultSet);
        }
        else
        {
            $sql .= " ORDER BY Date ASC, KickOff ASC";
            $resultSet = $this->_db->query($sql);
            return($resultSet);
        }

        return false;
    }

    public function update($fields = array(), $id)
    {
        if(!$this->_db->update('matches', $fields, 'MatchId = ' . $id))
        {
            throw new Exception('Error updating.');
        }
    }

}

