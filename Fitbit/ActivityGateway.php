<?php
/**
 *
 * Error Codes: 601 - 618
 */
namespace Nibynool\FitbitInterfaceBundle\Fitbit;

use SimpleXMLElement;
use Symfony\Component\Stopwatch\Stopwatch;
use Nibynool\FitbitInterfaceBundle\Fitbit\Exception as FBException;

/**
 * Class ActivityGateway
 *
 * @package Nibynool\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.1.0
 */
class ActivityGateway extends EndpointGateway
{
    /**
     * Get user's activity statistics
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getActivityStats()
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Get Activity Stats', 'Fitbit_API');
        try
        {
	        /** @var SimpleXMLElement|object $activityStats */
	        $activityStats = $this->makeApiRequest('user/' . $this->userID . '/activities');
	        $timer->stop('Get Activity Stats');
	        return $activityStats;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Activity Stats');
	        throw new FBException('Activity statistics request failed.', 601, $e);
        }
    }

    /**
     * Get user activities for specific date
     *
     * @access public
     * @version 0.5.2
     *
     * @param  \DateTime $date
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getActivities(\DateTime $date)
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Get Activities', 'Fitbit_API');

        $dateStr = $date->format('Y-m-d');

        try
        {
	        /** @var SimpleXMLElement|object $activities */
	        $activities = $this->makeApiRequest('user/' . $this->userID . '/activities/date/' . $dateStr);
	        $timer->stop('Get Activities');
	        return $activities;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Activities');
	        throw new FBException('Get activities by date request failed.', 602, $e);
        }
    }

    /**
     * Get user recent activities
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getRecentActivities()
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Get Recent Activities', 'Fitbit_API');

	    try
	    {
		    /** @var SimpleXMLElement|object $recentActivities */
		    $recentActivities = $this->makeApiRequest('user/-/activities/recent');
		    $timer->stop('Get Recent Activities');
		    return $recentActivities;
	    }
	    catch (Exception $e)
	    {
		    $timer->stop('Get Recent Activities');
		    throw new FBException('Get recent activities request failed.', 603, $e);
	    }
    }

    /**
     * Get user frequent activities
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getFrequentActivities()
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Get Frequent Activities', 'Fitbit_API');

        try
        {
	        /** @var SimpleXMLElement|object $frequentActivities */
	        $frequentActivities = $this->makeApiRequest('user/-/activities/frequent');
	        $timer->stop('Get Frequent Activities');
	        return $frequentActivities;
        }
        catch (Exception $e)
        {
	        $timer->stop('Get Frequent Activities');
	        throw new FBException('Request for frequent activities failed.', 604, $e);
        }
    }

    /**
     * Get user favorite activities
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getFavoriteActivities()
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Get Favorite Activities', 'Fitbit_API');

        try
        {
	        /** @var SimpleXMLElement|object $favoriteActivities */
	        $favoriteActivities = $this->makeApiRequest('user/-/activities/favorite');
	        $timer->stop('Get Favorite Activities');
	        return $favoriteActivities;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Favorite Activities');
	        throw new FBException('Request for favorite activities failed.', 605, $e);
        }
    }

    /**
     * Log user activity
     *
     * @access public
     * @version 0.5.2
     *
     * @param \DateTime $date Activity date and time (set proper timezone, which could be fetched via getProfile)
     * @param int|string $activity Activity Id (or Intensity Level Id) from activities database,
     *                                  see http://wiki.fitbit.com/display/API/API-Log-Activity or a new activity name
     * @param string $duration Duration millis
     * @param string $calories Manual calories to override Fitbit estimate
     * @param string $distance Distance in km/miles (as set with setMetric)
     * @param string $distanceUnit Distance unit string (see http://wiki.fitbit.com/display/API/API-Distance-Unit)
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function logActivity(\DateTime $date, $activity, $duration, $calories = null, $distance = null, $distanceUnit = null)
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Log Activity', 'Fitbit_API');

	    if (!isset($date))
	    {
		    $timer->stop('Log Activity');
		    throw new FBException('Start date must be defined.', 614);
	    }
	    if (!isset($activity) || (!is_string($activity) && !is_integer($activity)))
	    {
		    $timer->stop('Log Activity');
		    throw new FBException('Activity must be defined as a string or integer.', 615);
	    }
	    if (!is_integer($duration))
	    {
		    $timer->stop('Log Activity');
		    throw new FBException('Duration must be defined in milliseconds.', 613);
	    }
        $parameters = array();
        $parameters['date'] = $date->format('Y-m-d');
        $parameters['startTime'] = $date->format('H:i');
	    if (is_string($activity))
        {
	        if (!isset($calories) || !is_integer($calories))
	        {
		        $timer->stop('Log Activity');
		        throw new FBException('Calories must be defined when using a manual activity.', 612);
	        }
            $parameters['activityName'] = $activity;
            $parameters['manualCalories'] = $calories;
        }
        else
        {
            $parameters['activityId'] = $activity;
            if (isset($calories)) $parameters['manualCalories'] = $calories;
        }
        $parameters['durationMillis'] = $duration;
        if (isset($distance))
        {
	        if (!is_numeric($distance)) throw new FBException('When distance is defined it must be a number.', 616);
	        $parameters['distance'] = $distance;
        }
        if (isset($distanceUnit))
        {
	        if (!in_array($distanceUnit, $this->configuration['distance_units']))
	        {
		        $timer->stop('Log Activity');
		        throw new FBException('Invalid distance unit provided.', 617);
	        }
		    $parameters['distanceUnit'] = $distanceUnit;
        }
        try
        {
	        /** @var SimpleXMLElement|object $loggedActivity */
	        $loggedActivity = $this->makeApiRequest('user/-/activities', 'POST', $parameters);
	        $timer->stop('Log Activity');
	        return $loggedActivity;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Log Activity');
	        throw new FBException('Failed logging activity.', 606, $e);
        }
    }

    /**
     * Delete user activity
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $id Activity log id
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function deleteActivity($id)
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Delete Activity', 'Fitbit_API');

	    if (!is_integer($id))
	    {
		    $timer->stop('Delete Activity');
		    throw new FBException('Invalid ID format provided.', 618);
	    }
	    try
	    {
		    /** @var SimpleXMLElement|object $deletedActivity */
		    $deletedActivity = $this->makeApiRequest('user/-/activities/' . $id, 'DELETE');
		    $timer->stop('Delete Activity');
		    return $deletedActivity;
	    }
	    catch (\Exception $e)
	    {
		    throw new FBException('Request to delete activity failed.', 607, $e);
	    }
    }

    /**
     * Add user favorite activity
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $id Activity log id
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function addFavoriteActivity($id)
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Add Favorite Activity', 'Fitbit_API');

	    if (!is_integer($id))
	    {
		    $timer->stop('Add Favorite Activity');
		    throw new FBException('Invalid ID format provided.', 619);
	    }
	    try
        {
	        /** @var SimpleXMLElement|object $favoriteActivity */
	        $favoriteActivity = $this->makeApiRequest('user/-/activities/log/favorite/' . $id, 'POST');
	        $timer->stop('Add Favorite Activity');
	        return $favoriteActivity;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Add Favorite Activity');
	        throw new FBException('Unable to add favorite activity.', 608, $e);
        }
    }

    /**
     * Delete user favorite activity
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $id Activity log id
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function deleteFavoriteActivity($id)
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Delete Favorite Activity', 'Fitbit_API');

	    if (!is_integer($id))
	    {
		    $timer->stop('Delete Favorite Activity');
		    throw new FBException('Invalid ID format provided.', 620);
	    }
        try
        {
	        /** @var SimpleXMLElement|object $deletedFavorite */
	        $deletedFavorite = $this->makeApiRequest('user/-/activities/log/favorite/' . $id, 'DELETE');
	        $timer->stop('Delete Favorite Activity');
	        return $deletedFavorite;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Delete Favorite Activity');
	        throw new FBException('Unable to delete favorite activity.', 609, $e);
        }
    }

    /**
     * Get full description of specific activity
     *
     * @access public
     * @version 0.5.2
     *
     * @param  string $id Activity log Id
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getActivity($id)
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Get Activity', 'Fitbit_API');

	    if (!is_integer($id))
	    {
		    $timer->stop('Get Activity');
		    throw new FBException('Invalid ID format provided.', 621);
	    }
        try
        {
	        /** @var SimpleXMLElement|object $activity */
	        $activity = $this->makeApiRequest('activities/' . $id);
	        $timer->stop('Get Activity');
	        return $activity;
        }
        catch (Exception $e)
        {
	        $timer->stop('Get Activity');
	        throw new FBException('Unable to get the requested activity.', 610, $e);
        }
    }

    /**
     * Get a tree of all valid Fitbit public activities as well as private custom activities the user createds
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function browseActivities()
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Browse Activities', 'Fitbit_API');

        try
        {
	        /** @var SimpleXMLElement|object $activities */
	        $activities = $this->makeApiRequest('activities');
	        $timer->stop('Browse Activities');
	        return $activities;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Browse Activities');
	        throw new FBException('Unable to get a list of activities.', 611, $e);
        }
    }
}
