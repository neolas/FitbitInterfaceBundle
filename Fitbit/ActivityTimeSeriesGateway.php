<?php
/**
 *
 * Error Codes: 8XX
 */
namespace Neolas\FitbitInterfaceBundle\Fitbit;

/**
 * Class ActivityTimeSeriesGateway
 *
 * @package Neolas\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.1.0
 * @version 0.5.0
 *
 * @method object getCalories(bool $tracker = false, \DateTime $baseDate = null, \DateTime $endDate = null)
 * @method object getCaloriesBMR(bool $tracker = false, \DateTime $baseDate = null, \DateTime $endDate = null)
 * @method object getSteps(bool $tracker = false, \DateTime $baseDate = null, \DateTime $endDate = null)
 * @method object getDistance(bool $tracker = false, \DateTime $baseDate = null, \DateTime $endDate = null)
 * @method object getFloors(bool $tracker = false, \DateTime $baseDate = null, \DateTime $endDate = null)
 * @method object getElevation(bool $tracker = false, \DateTime $baseDate = null, \DateTime $endDate = null)
 * @method object getMinutesSedentary(bool $tracker = false, \DateTime $baseDate = null, \DateTime $endDate = null)
 * @method object getMinutesLightlyActive(bool $tracker = false, \DateTime $baseDate = null, \DateTime $endDate = null)
 * @method object getMinutesFairlyActive(bool $tracker = false, \DateTime $baseDate = null, \DateTime $endDate = null)
 * @method object getMinutesVeryActive(bool $tracker = false, \DateTime $baseDate = null, \DateTime $endDate = null)
 * @method object getActivityCalories(bool $tracker = false, \DateTime $baseDate = null, \DateTime $endDate = null)
 */
class ActivityTimeSeriesGateway extends TimeSeriesEndpointGateway
{
    /**
     * base fragment for this resources uri
     * 
     * @var string
     */
    protected static $format = 'activities/%s/date';

    /**
     * convert to tracker only fragment
     *
     * @access protected
     *
     * @param string $fragment
     * @return string
     */
	protected function trackerOnlyFragment($fragment)
    {   
        return str_replace('activities', 'activities/tracker', $fragment);
    }

    /**
     * extended get to all for tracker only resource calls
     *
     * @access public
     * @version 0.5.0
     *
     * @param  string $fragment
     * @param  bool $tracker
     * @param  \DateTime|string $baseDate
     * @param  \DateTime|string $endDate
     * @return mixed SimpleXMLElement or the value encoded in json as an object
     */
    public function get($fragment, $tracker = false, $baseDate = null, $endDate = null)
    {
	    $fragment = ($tracker) ? $this->trackerOnlyFragment($fragment) : $fragment;
        return parent::get($fragment, $baseDate, $endDate);
    }

    /**
     * extended call, to ensure methods without tracker
     * have tracker set to false
     * 
     * {@inheritdoc}
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, array('getCaloriesBMR'))) $parameters[0] = false; 
        return parent::__call($method, $parameters);        
    }
}