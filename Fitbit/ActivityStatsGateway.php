<?php
/**
 *
 * Error Codes: 701
 */
namespace Neolas\FitbitInterfaceBundle\Fitbit;

use Neolas\FitbitInterfaceBundle\Fitbit\Exception as FBException;

/**
 * Class ActivityStatsGateway
 *
 * @package Neolas\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.5.0
 * @deprecated 0.5.1 use ActivityGateway::getActivityStats
 */
class ActivityStatsGateway extends EndpointGateway
{
	public function __construct($config)
	{
		trigger_error('The ActivityStatsGateway class has been deprecated and should no longer be used.', E_WARNING);
		parent::__construct($config);
	}

	/**
     * Get user body measurements
     *
     * @access public
     * @version 0.5.0
     *
     * @throws FBException
     * @return mixed SimpleXMLElement or the value encoded in json as an object
     */
    public function getStats()
    {
        try
        {
	        return $this->makeApiRequest('user/' . $this->userID . '/activities');
        }
        catch (\Exception $e)
        {
	        throw new FBException('Unable to get activity statistics.', 701, $e);
        }
    }
}
