<?php
    
class League
{
    private $_db,
            $_data,
            $_teams,
            $_countOpps;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    // CREATE OPPONENT
    public function createOpponent($fields)
    {
        if(!$this->_db->insert('opponent', $fields))
        {
            throw new Exception('Error creating opponent');
        }
    }

    // READ OPPONENT
    public function getOpponents()
    {
        $opponents = $this->_db->get('opponent');

        if($opponents->count())
        {
            return $opponents->results();
        }

        return false;
    }

    public function getOpponentById($OpponentId)
    {
        $opponents = $this->_db->get('opponent', array('OpponentId', '=', $OpponentId));

        if($opponents->count())
        {
            $this->_countOpps = $opponents->count();
            return $opponents->results();
        }

        return false;
    }

    // UPDATE OPPONENT
    public function updateOpponent($fields = array(), $id)
    {
        if(!$this->_db->update('opponent', $fields, 'OpponentId = ' . $id))
        {
            throw new Exception('Error updating.');
        }
    }

    // DELETE OPPONENT
    public function deleteOpponent($opponentId)
    {
        $where =  array('OpponentId', '=', $opponentId);

        if(!$this->_db->delete('opponent', $where))
        {
            throw new Exception('Error deleting opponent');
        }
    }

    // CREATE LOCATION
    public function createLocation($fields)
    {
        if(!$this->_db->insert('location', $fields))
        {
            throw new Exception('Error creating location');
        }
    }

    // READ LOCATION
    public function getLocations()
    {
        $locations = $this->_db->get('location');

        if($locations->count())
        {
            return $locations->results();
        }

        return false;
    }

    public function getLocationById($LocationId)
    {
        $location = $this->_db->get('location', array('LocationId', '=', $LocationId));

        if($location->count())
        {
            return $location;
        }

        return false;
    }

    // UPDATE Location
    public function updateLocation($fields = array(), $id)
    {
        if(!$this->_db->update('location', $fields, 'LocationId = ' . $id))
        {
            throw new Exception('Error updating.');
        }
    }

    // DELETE Location
    public function deleteLocation($locationId)
    {
        $where =  array('LocationId', '=', $locationId);

        if(!$this->_db->delete('location', $where))
        {
            throw new Exception('Error deleting Location');
        }
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

    // CREATE OPPONENT
    public function createCompetition($fields)
    {
        if(!$this->_db->insert('competitions', $fields))
        {
            throw new Exception('Error creating competition');
        }
    }

    // DELETE OPPONENT
    public function deleteCompetition($competitionId)
    {
        $where =  array('CompetitionId', '=', $competitionId);

        if(!$this->_db->delete('competitions', $where))
        {
            throw new Exception('Error deleting Competition');
        }
    }

}

