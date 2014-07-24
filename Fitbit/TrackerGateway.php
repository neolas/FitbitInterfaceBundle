<?php
/**
 *
 * Error Codes: 1501-1502
 */
namespace Nibynool\FitbitInterfaceBundle\Fitbit;

use SimpleXMLElement;
use Symfony\Component\Stopwatch\Stopwatch;
use Nibynool\FitbitInterfaceBundle\Fitbit\Exception as FBException;

/**
 * Class TrackerGateway
 *
 * @package Nibynool\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.5.0
 */
class TrackerGateway extends EndpointGateway {

	/**
	 * Get list of devices and their properties
	 *
	 * @access public
	 * @since 0.5.1
	 * @version 0.5.2
	 *
	 * @throws FBException
	 * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
	 */
	public function getDevices()
	{
		/** @var Stopwatch $timer */
		$timer = new Stopwatch();
		$timer->start('Get Devices', 'Fitbit API');

		try
		{
			/** @var SimpleXMLElement|object $devices */
			$devices = $this->makeApiRequest('user/-/devices');
			$timer->stop('Get Devices');
			return $devices;
		}
		catch (\Exception $e)
		{
			$timer->stop('Get Devices');
			throw new FBException('Could not get the device list.', 1502, $e);
		}
	}

    /**
     * Get alarm settings
     *
     * @access public
     * @version 0.5.2
     *
     * @param  string $tracker
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getAlarms($tracker)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Alarms', 'Fitbit API');

	    try
        {
	        /** @var SimpleXMLElement|object $alarms */
	        $alarms = $this->makeApiRequest('user/' . $this->userID . '/devices/tracker/' . $tracker . '/alarms');
	        $timer->stop('Get Alarms');
	        return $alarms;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Alarms');
	        throw new FBException('Could not get silent alarms.', 1501, $e);
        }
    }
}
