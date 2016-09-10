<?php
/**
 *
 * Error Codes: 1601-1616
 */
namespace Neolas\FitbitInterfaceBundle\Fitbit;

use SimpleXMLElement;
use Symfony\Component\Stopwatch\Stopwatch;
use Neolas\FitbitInterfaceBundle\Fitbit\Exception as FBException;

/**
 * Class UserGateway
 *
 * @package Neolas\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.1.0
 */
class UserGateway extends EndpointGateway
{
    /**
     * API wrappers
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getProfile()
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Profile', 'Fitbit API');

	    try
        {
	        /** @var SimpleXMLElement|object $profile */
	        $profile = $this->makeApiRequest('user/' . $this->userID . '/profile');
	        $timer->stop('Get Profile');
	        return $profile;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Profile');
	        throw new FBException('Could not get the profile.', 1601, $e);
        }
    }

    /**
     * Update user profile with array of parameters.
     *
     * @access public
     * @version 0.5.2
     *
     * @param array $parameters
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function updateProfileFromArray($parameters)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Update Profile', 'Fitbit API');

	    try
        {
	        /** @var SimpleXMLElement|object $profile */
	        $profile = $this->makeApiRequest('user/' . $this->userID . '/profile', 'POST', $parameters);
	        $timer->stop('Update Profile');
	        return $profile;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Update Profile');
	        throw new FBException('Could not update the user profile.', 1602, $e);
        }
    }

    /**
     * Update user profile
     *
     * @access public
     * @version 0.5.0
     *
     * @param string $gender 'FEMALE', 'MALE' or 'NA'
     * @param \DateTime $birthday Date of birth
     * @param string $height Height in cm/inches (as set with setMetric)
     * @param string $nickname Nickname
     * @param string $fullName Full name
     * @param string $timezone Timezone in the format 'America/Los_Angeles'
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function updateProfile($gender = null, \DateTime $birthday = null, $height = null, $nickname = null, $fullName = null, $timezone = null)
    {
        $parameters = array();
        if ($gender)   $parameters['gender'] = $gender;
        if ($birthday) $parameters['birthday'] = $birthday->format('Y-m-d');
        if ($height)   $parameters['height'] = $height;
        if ($nickname) $parameters['nickname'] = $nickname;
        if ($fullName) $parameters['fullName'] = $fullName;
        if ($timezone) $parameters['timezone'] = $timezone;

        try
        {
	        return $this->updateProfileFromArray($parameters);
        }
        catch (\Exception $e)
        {
	        throw new FBException('Could not update the user profile.', 1603, $e);
        }
    }

    /**
     * Get list of devices and their properties
     *
     * @access public
     * @version 0.5.0
     * @deprecated 0.5.1
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getDevices()
    {
        try
        {
	        return $this->makeApiRequest('user/-/devices');
        }
        catch (\Exception $e)
        {
	        throw new FBException('Could not get the device list.', 1604, $e);
        }
    }

    /**
     * Get user friends
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getFriends()
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Friends', 'Fitbit API');

	    try
	    {
		    /** @var SimpleXMLElement|object $friends */
		    $friends = $this->makeApiRequest('user/' . $this->userID . '/friends');
		    $timer->stop('Get Friends');
		    return $friends;
	    }
	    catch (\Exception $e)
	    {
		    $timer->stop('Get Friends');
		    throw new FBException('Could not get the friends list.', 1605, $e);
	    }
    }

    /**
     * Get user's friends leaderboard
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getFriendsLeaderboard()
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Friends Leaderboard', 'Fitbit API');

	    try
        {
	        /** @var SimpleXMLElement|object $leaderboard */
	        $leaderboard = $this->makeApiRequest('user/-/friends/leaderboard');
	        $timer->stop('Get Friends Leaderboard');
	        return $leaderboard;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Friends Leaderboard');
	        throw new FBException('Could not get the friends leaderboard.', 1607, $e);
        }
    }

	/**
	 * Get friend invites
	 *
	 * @access public
	 * @version 0.5.2
	 *
	 * @throws FBException
	 * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
	 */
	public function getInvites()
	{
		/** @var Stopwatch $timer */
		$timer = new Stopwatch();
		$timer->start('Get Invites', 'Fitbit API');

		try
		{
			/** @var SimpleXMLElement|object $invites */
			$invites = $this->makeApiRequest('user/-/friends/invitations');
			$timer->stop('Get Invites');
			return $invites;
		}
		catch (\Exception $e)
		{
			$timer->stop('Get Invites');
			throw new FBException('Could not get friend invitations.', 1606, $e);
		}
	}

    /**
     * Invite user to become friends
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $userId Invite user by id
     * @param string $email Invite user by email address (could be already Fitbit member or not)
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function inviteFriend($userId = null, $email = null)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Invite Friend', 'Fitbit API');

	    $parameters = array();
        if (isset($userId)) $parameters['invitedUserId'] = $userId;
        if (isset($email)) $parameters['invitedUserEmail'] = $email;

        try
        {
	        /** @var SimpleXMLElement|object $invite */
	        $invite = $this->makeApiRequest('user/-/friends/invitations', 'POST', $parameters);
	        $timer->stop('Invite Friend');
	        return $invite;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Invite Friend');
	        throw new FBException('Could not invite the chosen friend', 1608, $e);
        }
    }

    /**
     * Accept invite to become friends from user
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $userId Id of the inviting user
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function acceptFriend($userId)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Accept Friend', 'Fitbit API');

	    $parameters = array();
        $parameters['accept'] = 'true';

        try
        {
	        /** @var SimpleXMLElement|object $acceptance */
	        $acceptance = $this->makeApiRequest('user/-/friends/invitations/' . $userId, 'POST', $parameters);
	        $timer->stop('Accept Friend');
	        return $acceptance;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Accept Friend');
	        throw new FBException('Could not accept friend invitation.', 1609, $e);
        }
    }

    /**
     * Reject invite to become friends from user
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $userId Id of the inviting user
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function rejectFriend($userId)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Reject Friend', 'Fitbit API');

	    $parameters = array();
        $parameters['accept'] = 'false';

	    try
	    {
		    /** @var SimpleXMLElement|object $rejection */
		    $rejection = $this->makeApiRequest('user/-/friends/invitations/' . $userId, 'POST', $parameters);
		    $timer->stop('Reject Friend');
		    return $rejection;
	    }
	    catch (\Exception $e)
	    {
		    $timer->stop('Reject Friend');
		    throw new FBException('Could not reject friend request.', 1610, $e);
	    }
    }

	/**
	 * Get badges
	 *
	 * @access public
	 * @version 0.5.2
	 *
	 * @throws FBException
	 * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
	 */
	public function getBadges()
	{
		/** @var Stopwatch $timer */
		$timer = new Stopwatch();
		$timer->start('Get Badges', 'Fitbit API');

		try
		{
			/** @var SimpleXMLElement|object $badges */
			$badges = $this->makeApiRequest('user/-/badges');
			$timer->stop('Get Badges');
			return $badges;
		}
		catch (\Exception $e)
		{
			$timer->stop('Get Badges');
			throw new FBException('Could not get badges.', 1611, $e);
		}
	}

    /**
     * Add subscription
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $id Subscription ID
     * @param string $subscriptionType Collection type
     * @param string $subscriberId The ID of the subscriber
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function addSubscription($id, $subscriptionType = 'all', $subscriberId = null)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Add Subscription', 'Fitbit API');

	    try
        {
	        /** @var SimpleXMLElement|object $subscription */
	        $subscription = $this->makeApiRequest(
		        $this->makeSubscriptionUrl($id, $subscriptionType),
		        'POST',
		        array(),
		        $this->makeSubscriptionHeaders($subscriberId)
	        );
	        $timer->stop('Add Subscriptions');
	        return $subscription;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Add Subscriptions');
	        throw new FBException('Could not add subscription.', 1612, $e);
        }
    }

    /**
     * Delete user subscription
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $id Subscription Id
     * @param string $subscriptionType Collection type
     * @param string $subscriberId The ID of the subscriber
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function deleteSubscription($id, $subscriptionType = 'all', $subscriberId = null)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Delete Subscriptions', 'Fitbit API');

	    try
        {
	        /** @var SimpleXMLElement|object $result */
	        $result = $this->makeApiRequest(
		        $this->makeSubscriptionUrl($id, $subscriptionType),
		        'DELETE',
		        array(),
		        $this->makeSubscriptionHeaders($subscriberId)
	        );
	        $timer->stop('Delete Subscriptions');
	        return $result;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Delete Subscriptions');
	        throw new FBException('Could not delete subscription.', 1613, $e);
        }
    }

    /**
     * Validate user subscription type
     *
     * @access protected
     * @version 0.5.0
     *
     * @param string &$subscriptionType Collection type
     * @throws FBException
     * @return bool
     */
    protected function validateSubscriptionType(&$subscriptionType)
    {
	    if (!isset($this->configuration['subscription_types'][$subscriptionType])) throw new FBException('Invalid subscription type requested.', 1614);
	    $subscriptionType = $this->configuration['subscription_types'][$subscriptionType]['value'];
        return true;
    }

    /**
     * Create headers for subscription requests.
     *
     * @access protected
     *
     * @param string $subscriberId The ID of the subscriber
     * @return array
     */
    protected function makeSubscriptionHeaders($subscriberId = null)
    {
        $headers = array();
        if ($subscriberId) $headers['X-Fitbit-Subscriber-Id'] = $subscriberId;
        return $headers;
    }

    /**
     * Create the subscription request URL
     *
     * @access protected
     * @version 0.5.0
     *
     * @param string $id Subscription Id
     * @param string $subscriptionType subscriptionType resource path
     * @throws FBException
     * @return string
     */
    protected function makeSubscriptionUrl($id, $subscriptionType)
    {
	    try
	    {
		    $this->validateSubscriptionType($subscriptionType);
	    }
	    catch (\Exception $e)
	    {
		    throw new FBException('Invalid subscription type provided.', 1615, $e);
	    }
        return sprintf('user/%s%s/apiSubscriptions%s',
            $this->userID,
            $subscriptionType,
            ($id ? '/' . $id : '')
        );
    }

    /**
     * Get list of user's subscriptions for this application
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getSubscriptions()
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Subscriptions', 'Fitbit API');

	    try
        {
	        /** @var SimpleXMLElement|object $subscriptions */
	        $subscriptions = $this->makeApiRequest($this->makeSubscriptionUrl(null, null));
	        $timer->stop('Get Subscriptions');
	        return $subscriptions;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Subscriptions');
	        throw new FBException('Unable to get subscriptions.', 1615, $e);
        }
    }
}
