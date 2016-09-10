<?php
/**
 *
 * Error Codes: 1401-1403
 */
namespace Neolas\FitbitInterfaceBundle\Fitbit;

use OAuth\OAuth1\Token\StdOAuth1Token;
use OAuth\Common\Storage\Memory;
use OAuth\Common\Storage\Session;
use Neolas\FitbitInterfaceBundle\Fitbit\Exception as FBException;

/**
 * Class TokenStorage
 *
 * @package Neolas\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.1.0
 */
class TokenStorage
{
	/**
	 * @var StdOAuth1Token
	 */
	protected $token;
	/**
	 * @var Memory
	 */
	protected $adapter;

	/**
	 * Constructor for the token storage
	 *
	 * @access public
	 * @version 0.5.0
	 *
	 * @param string $storage The storage to use for the token
	 * @param string $token  The token to be added to the storage if this is pre-authorised
	 * @param string $secret The secret associated with the token.
	 * @throws FBException
	 */
	public function __construct($storage = 'memory', $token = null, $secret = null)
	{
		try
		{
			$this->token = new StdOAuth1Token();
		}
		catch(\Exception $e)
		{
			throw new FBException('Could not create token.', 1401, $e);
		}
		if ($storage == 'memory') $this->adapter = new Memory();
		elseif ($storage == 'session') $this->adapter = new Session();
		else throw new FBException('Invalid token storage provider.', 1402);

		if ($token !== null && $secret !== null)
		{
			try
			{
				$this->token->setRequestToken($token);
				$this->token->setRequestTokenSecret($secret);
				$this->token->setAccessToken($token);
				$this->token->setAccessTokenSecret($secret);
				$this->adapter->storeAccessToken('FitBit', $this->token);
			}
			catch(\Exception $e)
			{
				throw new FBException('Could not store token details.', 1403, $e);
			}
		}
	}

	/**
	 * Get the storage adapter
	 *
	 * @access public
	 * @version 0.1.1
	 *
	 * @return Memory|Session
	 */
	public function getAdapter()
	{
		return $this->adapter;
	}
}