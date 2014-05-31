<?php
/**
 *
 */
namespace Nibynool\FitbitInterfaceBundle\Fitbit;

/**
 * Class RequestLogger
 *
 * @package Nibynool\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.5.3
 */
class RequestLogger
{
	/**
	 * @var self[]
	 */
	private static $instances = array();

	/**
	 * @var array
	 */
	protected static $apiCalls = array();

	/**
	 * @var string
	 */
	protected static $user = '';

	/**
	 * @var array
	 */
	protected static $quota = array();

	/**
	 * Prevent normal instantiation
	 */
	protected function __construct() {}

	/**
	 * Prevent cloning
	 */
	protected function __clone() {}

	/**
	 *
	 * Prevent unserialization
	 *
	 * @throws Exception
	 */
	public function __wakeup()
	{
		throw new \Exception("Cannot unserialize singleton");
	}

	/**
	 * Return this class
	 *
	 * @return self
	 */
	public static function getInstance()
	{
		$cls = get_called_class();
		if (!isset(self::$instances[$cls])) self::$instances[$cls] = new static;

		return self::$instances[$cls];
	}

	/**
	 * Log quota details
	 *
	 * @param integer   $viewer
	 * @param integer   $client
	 * @param \DateTime $viewerReset
	 * @param \DateTime $clientReset
	 * @param integer   $viewerQuota
	 * @param integer   $clientQuota
	 */
	public static function logQuota($viewer, $client, \DateTime $viewerReset = null, \DateTime $clientReset = null, $viewerQuota = null, $clientQuota = null)
	{
		self::$quota = array(
			'viewer' => array(
				'remaining' => $viewer,
				'reset'     => $viewerReset,
				'quota'     => $viewerQuota
			),
			'client' => array(
				'remaining' => $client,
				'reset'     => $clientReset,
				'quota'     => $clientQuota
			)
		);
	}

	/**
	 * Log Fitbit User
	 *
	 * @param string $user
	 */
	public static function logUser($user)
	{
		self::$user = $user;
	}

	/**
	 * Log an API call for later retrieval
	 *
	 * @param array $call
	 * @param int   $time
	 * @param mixed $result
	 * @param \Exception $exception
	 */
	public static function logApiCall($call, $time, $result = null, \Exception $exception = null)
	{
		$exceptionArray = null;
		if ($exception)
		{
			$exceptionArray = array(
				'code'        => $exception->getCode(),
				'file'        => $exception->getFile(),
				'line'        => $exception->getLine(),
				'message'     => $exception->getMessage(),
				'traceString' => $exception->getTraceAsString(),
//				'traceArray'  => $exception->getTrace()
			);
		}

		self::$apiCalls[] = array(
			'call' => $call,
			'time' => $time,
			'result' => print_r($result, true),
			'exception' => $exceptionArray
		);
	}

	/**
	 * Get User
	 *
	 * @return string
	 */
	public static function getUser()
	{
		return self::$user;
	}

	/**
	 * Get Quota
	 *
	 * @return string
	 */
	public static function getQuota()
	{
		return self::$quota;
	}

	/**
	 * Get number of API Calls
	 *
	 * @return int
	 */
	public static function getCallCount()
	{
		return count(self::$apiCalls);
	}

	/**
	 * Get total time for all API calls
	 *
	 * @return int
	 */
	public static function getTime()
	{
		$time = 0;
		foreach (self::$apiCalls as $call)
		{
			$time += $call['time'];
		}
		return $time;
	}

	/**
	 * Get array of all API calls
	 *
	 * return array
	 */
	public static function getCallLog()
	{
		return self::$apiCalls;
	}
}