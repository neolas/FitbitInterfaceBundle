<?php
/**
 *
 */
namespace Nibynool\FitbitInterfaceBundle\DataCollectors;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nibynool\FitbitInterfaceBundle\Fitbit\RequestLogger;

/**
 * DataCollector Fitbit
 *
 * @package Nibynool\FitbitInterfaceBundle\DataCollectors
 *
 * @since 0.5.3
 */
class FitbitDataCollector extends DataCollector
{
	/**
	 * Collects data for the given Request and Response.
	 *
	 * @param Request    $request   A Request instance
	 * @param Response   $response  A Response instance
	 * @param \Exception $exception An Exception instance
	 */
	public function collect(Request $request, Response $response, \Exception $exception = null)
	{
		$this->data = array(
			'count' => RequestLogger::getCallCount(),
			'time'  => RequestLogger::getTime(),
			'logs'  => RequestLogger::getCallLog(),
			'quota' => RequestLogger::getQuota()
		);
	}

	/**
	 * Get the number of Fitbit API calls made
	 * @return int
	 */
	public function getCount()
	{
		return $this->data['count'];
	}

	/**
	 * Get the Fitbit API quota details
	 * @return array
	 */
	public function getQuota()
	{
		return $this->data['quota'];
	}

	/**
	 * Get the time spent making Fitbit API calls
	 *
	 * @return int
	 */
	public function getTime()
	{
		return $this->data['time'];
	}

	/**
	 * Get details about the Fitbit API calls
	 *
	 * @return array
	 */
	public function getLogs()
	{
		return $this->data['logs'];
	}

	/**
	 * Returns the name of the collector.
	 *
	 * @return string The collector name
	 */
	public function getName()
	{
		return 'Fitbit Interface';
	}
}
