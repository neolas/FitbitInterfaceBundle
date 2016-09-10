<?php
/**
 *
 * Error Codes: 20XX
 */
namespace Neolas\FitbitInterfaceBundle\Fitbit;

/**
 * Class SleepTimeSeriesGateway
 *
 * @package Neolas\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.1.0
 * @version 0.5.0
 *
 * @method array getStartTime(\DateTime $baseDate, \DateTime $endDate)
 * @method array getTimeInBed(\DateTime $baseDate, \DateTime $endDate)
 * @method array getMinutesAsleep(\DateTime $baseDate, \DateTime $endDate)
 * @method array getAwakeningsCount(\DateTime $baseDate, \DateTime $endDate)
 * @method array getMinutesAwake(\DateTime $baseDate, \DateTime $endDate)
 * @method array getMinutesToFallAsleep(\DateTime $baseDate, \DateTime $endDate)
 * @method array getMinutesAfterWakeup(\DateTime $baseDate, \DateTime $endDate)
 * @method array getEfficiency(\DateTime $baseDate, \DateTime $endDate)
 */
class SleepTimeSeriesGateway extends TimeSeriesEndpointGateway {
    /**
     * base fragment for this resources uri
     * 
     * @var string
     */
    protected static $format = 'sleep/%s/date';
}
