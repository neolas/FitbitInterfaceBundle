<?php
/**
 *
 * Error Codes: 1201-1204
 */
namespace Neolas\FitbitInterfaceBundle\Fitbit;

use Neolas\FitbitInterfaceBundle\Fitbit\Exception as FBException;

/**
 * Class TimeGateway
 *
 * @package Neolas\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.1.0
 * @deprecated 0.5.0 No replacement available
 */
class TimeGateway extends EndpointGateway
{
	public function __construct($config)
	{
		trigger_error('The TimeGateway class has been deprecated and should no longer be used.', E_WARNING);
		parent::__construct($config);
	}

    /**
     * Launch TimeSeries requests
     *
     * @access public
     * @version 0.5.0
     *
     * @param string $type
     * @param  $basedate \DateTime or 'today', to_period
     * @param  $to_period \DateTime or '1d, 7d, 30d, 1w, 1m, 3m, 6m, 1y, max'
     * @throws FBException
     * @return array
     */
    public function getTimeSeries($type, $basedate, $to_period)
    {
	    if (!isset($this->configuration['interday_timeseries_endpoints'][$type])) throw new FBException('Invalid time-series end-point requested.', 1203);
	    $path = $this->configuration['interday_timeseries_endpoints'][$type]['value'];
	    try
	    {
	        return $this->makeApiRequest(sprintf('user/%s/date/%s/%s',
	            $this->userID . $path,
	            (is_string($basedate) ? $basedate : $basedate->format('Y-m-d')),
	            (is_string($to_period) ? $to_period : $to_period->format('Y-m-d')))
	        );
	    }
	    catch (\Exception $e)
	    {
		    throw new FBException('Unable to get data from time series ('.$type.')', 1201, $e);
	    }
    }

    /**
     * Launch Intraday TimeSeries requests
     *
     * @access public
     * @version 0.5.0
     *
     * @param string $type
     * @param  $date \DateTime or 'today'
     * @param  $start_time \DateTime
     * @param  $end_time \DateTime
     * @throws FBException
     * @return object
     */
    public function getIntradayTimeSeries($type, $date, $start_time = null, $end_time = null)
    {
	    if (!isset($this->configuration['intraday_timeseries_endpoints'][$type])) throw new FBException('Invalid time-series end-point requested.', 1204);
	    $path = $this->configuration['interday_timeseries_endpoints'][$type]['value'];

        try
        {
	        return $this->makeApiRequest(sprintf('user/-%s/date/%s/1d%s',
			        $path,
			        (is_string($date) ? $date : $date->format('Y-m-d')),
			        ((!empty($start_time) && !empty($end_time)) ? '/time/' . $start_time->format('H:i') . '/' . $end_time->format('H:i') : ''))
	        );
        }
        catch(\Exception $e)
        {
	        throw new FBException('Unable to get intra-day time series ('.$type.')', 1202, $e);
        }
    }
}
