<?php
/**
 *
 * Error Codes: 19XX
 */
namespace Neolas\FitbitInterfaceBundle\Fitbit;

/**
 * Class RateLimiting
 *
 * @package Neolas\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.1.0
 */
class RateLimiting
{
	/**
	 * @var integer
	 */
	public $viewer;
	/**
	 * @var \DateTime
	 */
	public $viewerReset;
	/**
	 * @var integer
	 */
	public $viewerQuota;
	/**
	 * @var integer
	 */
	public $client;
	/**
	 * @var \DateTime
	 */
	public $clientReset;
	/**
	 * @var integer
	 */
	public $clientQuota;

	/**
	 * @param integer   $viewer
	 * @param integer   $client
	 * @param \DateTime $viewerReset
	 * @param \DateTime $clientReset
	 * @param integer   $viewerQuota
	 * @param integer   $clientQuota
	 */
	public function __construct($viewer, $client, \DateTime $viewerReset = null, \DateTime $clientReset = null, $viewerQuota = null, $clientQuota = null)
    {
        $this->viewer = $viewer;
        $this->viewerReset = $viewerReset;
        $this->viewerQuota = $viewerQuota;
        $this->client = $client;
        $this->clientReset = $clientReset;
        $this->clientQuota = $clientQuota;
    }
}