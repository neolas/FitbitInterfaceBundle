<?php
/**
 *
 * Error Codes: 1701-1704
 */
namespace Nibynool\FitbitInterfaceBundle\Fitbit;

use SimpleXMLElement;
use Symfony\Component\Stopwatch\Stopwatch;
use Nibynool\FitbitInterfaceBundle\Fitbit\Exception as FBException;

/**
 * Class WaterGateway
 *
 * @package Nibynool\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.1.0
 */
class WaterGateway extends EndpointGateway {

    /**
     * Get user water log entries for specific date
     *
     * @access public
     * @version 0.5.2
     *
     * @param  \DateTime $date
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getWater(\DateTime $date)
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Get Water', 'Fitbit_API');

	    $dateStr = $date->format('Y-m-d');

        try
        {
	        /** @var SimpleXMLElement|object $water */
	        $water = $this->makeApiRequest('user/-/foods/log/water/date/' . $dateStr);
	        $timer->stop('Get Water');
	        return $water;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Water');
	        throw new FBException('Could not get water records.', 1701, $e);
        }
    }

    /**
     * Log user water
     *
     * @access public
     * @version 0.5.2
     *
     * @todo Can this use a time in the date string?
     *
     * @param \DateTime $date Log entry date (set proper timezone, which could be fetched via getProfile)
     * @param string $amount Amount in ml/fl oz (as set with setMetric) or waterUnit
     * @param string $waterUnit Water Unit ("ml", "fl oz" or "cup")
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function logWater(\DateTime $date, $amount, $waterUnit = null)
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Log Water', 'Fitbit_API');

	    $parameters = array();
        $parameters['date'] = $date->format('Y-m-d');
        $parameters['amount'] = $amount;
        if (isset($waterUnit) && in_array($waterUnit, $this->configuration['water_units'][$waterUnit])) $parameters['unit'] = $waterUnit;
	    else throw new FBException('Invalid water unit provided.', 1702);

        try
        {
	        /** @var SimpleXMLElement|object $water */
	        $water = $this->makeApiRequest('user/-/foods/log/water', 'POST', $parameters);
	        $timer->stop('Log Water');
	        return $water;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Log Water');
	        throw new FBException('Could not log water consumption.', 1703, $e);
        }
    }

    /**
     * Delete user water record
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $id Water log id
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function deleteWater($id)
    {
	    /** @var Stopwatch $timer */
	    $timer = $this->stopwatch;
	    $timer->start('Delete Water', 'Fitbit_API');

	    try
        {
	        /** @var SimpleXMLElement|object $result */
	        $result = $this->makeApiRequest('user/-/foods/log/water/' . $id, 'DELETE');
	        $timer->stop('Delete Water');
	        return $result;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Delete Water');
	        throw new FBException('Could not delete water record.', 1704, $e);
        }
    }
}
