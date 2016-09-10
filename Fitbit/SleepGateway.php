<?php
/**
 *
 * Error Codes: 1101-1103
 */
namespace Neolas\FitbitInterfaceBundle\Fitbit;

use SimpleXMLElement;
use Symfony\Component\Stopwatch\Stopwatch;
use Neolas\FitbitInterfaceBundle\Fitbit\Exception as FBException;

/**
 * Class SleepGateway
 *
 * @package Neolas\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.1.0
 */
class SleepGateway extends EndpointGateway {

    /**
     * Get user sleep log entries for specific date
     *
     * @access public
     * @version 0.5.2
     *
     * @param  \DateTime $date
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getSleep($date)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Sleep', 'Fitbit API');

	    $dateStr = $date->format('Y-m-d');

	    try
	    {
		    /** @var SimpleXMLElement|object $sleep */
		    $sleep = $this->makeApiRequest('user/' . $this->userID . '/sleep/date/' . $dateStr);
		    $timer->stop('Get Sleep');
		    return $sleep;
	    }
	    catch (\Exception $e)
	    {
		    $timer->stop('Get Sleep');
		    throw new FBException('Unable to get sleep records.', 1101, $e);
	    }
    }

    /**
     * Log user sleep
     *
     * @access public
     * @version 0.5.2
     *
     * @param \DateTime $date Sleep date and time (set proper timezone, which could be fetched via getProfile)
     * @param string $duration Duration millis
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function logSleep(\DateTime $date, $duration)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Log Sleep', 'Fitbit API');

	    $parameters = array();
        $parameters['date'] = $date->format('Y-m-d');
        $parameters['startTime'] = $date->format('H:i');
        $parameters['duration'] = $duration;

        try
        {
	        /** @var SimpleXMLElement|object $sleep */
	        $sleep = $this->makeApiRequest('user/-/sleep', 'POST', $parameters);
	        $timer->stop('Log Sleep');
	        return $sleep;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Log Sleep');
	        throw new FBException('Unable to add sleep load.', 1102, $e);
        }
    }

    /**
     * Delete user sleep record
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $id Activity log id
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function deleteSleep($id)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Delete Sleep', 'Fitbit API');

	    try
        {
	        /** @var SimpleXMLElement|object $result */
	        $result = $this->makeApiRequest('user/-/sleep/' . $id, 'DELETE');
	        $timer->stop('Delete Sleep');
	        return $result;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Delete Sleep');
	        throw new FBException('Unable to delete sleep record.', 1103, $e);
        }
    }
}
