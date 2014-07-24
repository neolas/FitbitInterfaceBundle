<?php
/**
 *
 * Error Codes: 1001-1006
 */
namespace Nibynool\FitbitInterfaceBundle\Fitbit;

use SimpleXMLElement;
use Symfony\Component\Stopwatch\Stopwatch;
use Nibynool\FitbitInterfaceBundle\Fitbit\Exception as FBException;

/**
 * Class GoalGateway
 *
 * @package Nibynool\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.5.0
 */
class GoalGateway extends EndpointGateway
{
    /**
     * Get weight goal
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getBodyWeightGoal()
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Body Weight Goal', 'Fitbit API');

        try
        {
	        /** @var SimpleXMLElement|object $goal */
	        $goal = $this->makeApiRequest('user/' . $this->userID . '/body/log/weight/goal');
	        $timer->stop('Get Body Weight Goal');
	        return $goal;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Body Weight Goal');
	        throw new FBException('Unable to get weight goal.', 1001, $e);
        }
    }

	/**
	 * Get body fat goal
	 *
	 * @access public
	 * @version 0.5.2
	 *
	 * @throws FBException
	 * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
	 */
	public function getBodyFatGoal()
	{
		/** @var Stopwatch $timer */
		$timer = new Stopwatch();
		$timer->start('Get Body Fat Goal', 'Fitbit API');

		try
		{
			/** @var SimpleXMLElement|object $goal */
			$goal = $this->makeApiRequest('user/' . $this->userID . '/body/log/fat/goal');
			$timer->stop('Get Body Fat Goal');
			return $goal;
		}
		catch (\Exception $e)
		{
			$timer->stop('Get Body Fat Goal');
			throw new FBException('Unable to get body fat goal.', 1002, $e);
		}
	}

	/**
	 * Get daily activity goal
	 *
	 * @access public
	 * @version 0.5.2
	 *
	 * @throws FBException
	 * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
	 */
	public function getActivityDailyGoal()
	{
		/** @var Stopwatch $timer */
		$timer = new Stopwatch();
		$timer->start('Get Activity Daily Goal', 'Fitbit API');

		try
		{
			/** @var SimpleXMLElement|object $goal */
			$goal = $this->makeApiRequest('user/' . $this->userID . '/activities/goals/daily');
			$timer->stop('Get Activity Daily Goal');
			return $goal;
		}
		catch (\Exception $e)
		{
			$timer->stop('Get Activity Daily Goal');
			throw new FBException('Unable to get daily activity goal.', 1003, $e);
		}
	}

	/**
	 * Get weekly activity goal
	 *
	 * @access public
	 * @version 0.5.2
	 *
	 * @throws FBException
	 * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
	 */
	public function getActivityWeeklyGoal()
	{
		/** @var Stopwatch $timer */
		$timer = new Stopwatch();
		$timer->start('Get Activity Weekly Goal', 'Fitbit API');

		try
		{
			/** @var SimpleXMLElement|object $goal */
			$goal = $this->makeApiRequest('user/' . $this->userID . '/activities/goals/weekly');
			$timer->stop('Get Activity Weekly Goal');
			return $goal;
		}
		catch (\Exception $e)
		{
			$timer->stop('Get Activity Weekly Goal');
			throw new FBException('Unable to get weekly activity goal.', 1004, $e);
		}
	}

	/**
	 * Get food goal
	 *
	 * @access public
	 * @version 0.5.2
	 *
	 * @throws FBException
	 * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
	 */
	public function getFoodGoal()
	{
		/** @var Stopwatch $timer */
		$timer = new Stopwatch();
		$timer->start('Get Food Goal', 'Fitbit API');

		try
		{
			/** @var SimpleXMLElement|object $goal */
			$goal = $this->makeApiRequest('user/' . $this->userID . '/foods/log/goal');
			$timer->stop('Get Food Goal');
			return $goal;
		}
		catch (\Exception $e)
		{
			$timer->stop('Get Food Goal');
			throw new FBException('Unable to get food goal.', 1005, $e);
		}
	}

	/**
	 * Get water goal
	 *
	 * @access public
	 * @version 0.5.2
	 *
	 * @throws FBException
	 * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
	 */
	public function getWaterGoal()
	{
		/** @var Stopwatch $timer */
		$timer = new Stopwatch();
		$timer->start('Get Water Goal', 'Fitbit API');

		try
		{
			/** @var SimpleXMLElement|object $goal */
			$goal = $this->makeApiRequest('user/' . $this->userID . '/foods/log/water/goal');
			$timer->stop('Get Water Goal');
			return $goal;
		}
		catch (\Exception $e)
		{
			$timer->stop('Get Water Goal');
			throw new FBException('Unable to get water goal.', 1006, $e);
		}
	}
}
