<?php
/**
 *
 * Error Codes: 9XX
 */
namespace Neolas\FitbitInterfaceBundle\Fitbit;

/**
 * Class BodyTimeSeriesGateway
 *
 * @package Neolas\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.1.0
 * @version 0.1.1
 *
 * @method array getBmi(\DateTime $baseDate, \DateTime $endDate)
 * @method array getFat(\DateTime $baseDate, \DateTime $endDate)
 * @method array getWeight(\DateTime $baseDate, \DateTime $endDate)
 */
class BodyTimeSeriesGateway extends TimeSeriesEndpointGateway
{
    /**
     * Base fragment for this resources uri
     *
     * @version 0.1.1
     * @var string
     */
    protected static $format = 'body/%s/date';

	/**
	 * Get the weight/bmi logs for the selected date range.
	 *
	 * @access public
	 * @version 0.5.0
	 *
	 * @param  \DateTime|string $baseDate
	 * @param  \DateTime|string $endDate
	 * @return array
	 */
	public function getWeightLogs($baseDate, $endDate)
	{
		return call_user_func_array(array($this, 'get'), array('body/log/weight/date', $baseDate, $endDate));
	}

	/**
	 * Get the body fat logs for the selected date range.
	 *
	 * @access public
	 * @version 0.5.0
	 *
	 * @param  \DateTime|string $baseDate
	 * @param  \DateTime|string $endDate
	 * @return array
	 */
	public function getFatLogs($baseDate, $endDate)
	{
		return call_user_func_array(array($this, 'get'), array('body/log/fat/date', $baseDate, $endDate));
	}
}