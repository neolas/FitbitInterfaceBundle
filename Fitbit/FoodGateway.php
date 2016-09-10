<?php
/**
 *
 * Error Codes: 501 - 513
 */
namespace Neolas\FitbitInterfaceBundle\Fitbit;

use SimpleXMLElement;
use Symfony\Component\Stopwatch\Stopwatch;
use Neolas\FitbitInterfaceBundle\Fitbit\Exception as FBException;

/**
 * Class FoodGateway
 *
 * @package Neolas\FitbitInterfaceBundle\Fitbit
 *
 * @since 0.1.0
 */
class FoodGateway extends EndpointGateway
{
    /**
     * Get user foods for specific date
     *
     * @access public
     * @version 0.5.2
     *
     * @param  \DateTime $date
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getFoods($date)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Foods', 'Fitbit API');

        $dateStr = $date->format('Y-m-d');

        try
        {
	        /** @var SimpleXMLElement|object $foods */
	        $foods = $this->makeApiRequest('user/' . $this->userID . '/foods/log/date/' . $dateStr);
	        $timer->stop('Get Foods');
	        return $foods;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Foods');
	        throw new FBException('Food data request failed.', 501, $e);
        }
    }

    /**
     * Get user recent foods
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getRecentFoods()
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Recent Foods', 'Fitbit API');

	    try
	    {
		    /** @var SimpleXMLElement|object $recentFoods */
	        $recentFoods = $this->makeApiRequest('user/-/foods/log/recent');
		    $timer->stop('Get Recent Foods');
		    return $recentFoods;
	    }
	    catch (\Exception $e)
	    {
		    $timer->stop('Get Recent Foods');
		    throw new FBException('Recent food data request failed.', 502, $e);
	    }
    }

    /**
     * Get user frequent foods
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getFrequentFoods()
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Frequent Foods', 'Fitbit API');

        try
        {
	        /** @var SimpleXMLElement|object $frequentFoods */
	        $frequentFoods = $this->makeApiRequest('user/-/foods/log/frequent');
	        $timer->stop('Get Frequent Foods');
	        return $frequentFoods;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Frequent Foods');
	        throw new FBException('Frequent food data request failed.', 503, $e);
        }
    }

    /**
     * Get user favorite foods
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getFavoriteFoods()
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Favorite Foods', 'Fitbit API');

        try
        {
	        /** @var SimpleXMLElement|object $favoriteFoods */
	        $favoriteFoods = $this->makeApiRequest('user/-/foods/log/favorite');
	        $timer->stop('Get Favorite Foods');
	        return $favoriteFoods;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Favorite Foods');
	        throw new FBException('Favorite food data request failed.', 504, $e);
        }
   }

    /**
     * Log user food
     *
     * @access public
     * @version 0.5.2
     *
     * @param \DateTime $date Food log date
     * @param string $foodId Food Id from foods database (see searchFoods)
     * @param string $mealTypeId Meal Type Id from foods database (see searchFoods)
     * @param string $unitId Unit Id, should be allowed for this food (see getFoodUnits and searchFoods)
     * @param string $amount Amount in specified units
     * @param string $foodName
     * @param int $calories
     * @param string $brandName
     * @param array $nutrition
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function logFood(\DateTime $date, $foodId, $mealTypeId, $unitId, $amount, $foodName = null, $calories = null, $brandName = null, $nutrition = null)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Log Food', 'Fitbit API');

        $parameters = array();
        $parameters['date'] = $date->format('Y-m-d');
        if (isset($foodName))
        {
            $parameters['foodName'] = $foodName;
            $parameters['calories'] = $calories;
            if (isset($brandName)) $parameters['brandName'] = $brandName;
            if (isset($nutrition))
            {
                foreach ($nutrition as $i => $value)
                {
                    $parameters[$i] = $nutrition[$i];
                }
            }
        }
        else $parameters['foodId'] = $foodId;
        $parameters['mealTypeId'] = $mealTypeId;
        $parameters['unitId'] = $unitId;
        $parameters['amount'] = $amount;

        try
        {
	        /** @var SimpleXMLElement|object $log */
	        $log = $this->makeApiRequest('user/-/foods/log', 'POST');
	        $timer->stop('Log Food');
	        return $log;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Log Food');
	        throw new FBException('Create food log failed.', 505, $e);
        }
    }

    /**
     * Delete user food
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $id Food log id
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function deleteFood($id)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Delete Food', 'Fitbit API');

        try
        {
	        /** @var SimpleXMLElement|object $result */
	        $result = $this->makeApiRequest('user/-/foods/log/' . $id, 'DELETE');
	        $timer->stop('Delete Food');
	        return $result;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Delete Food');
	        throw new FBException('Delete food log failed.', 506, $e);
        }
    }

    /**
     * Add user favorite food
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $id Food log id
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function addFavoriteFood($id)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Add Favorite Food', 'Fitbit API');

        try
        {
	        /** @var SimpleXMLElement|object $favoriteFood */
	        $favoriteFood = $this->makeApiRequest('user/-/foods/log/favorite/' . $id, 'POST');
	        $timer->stop('Add Favorite Food');
	        return $favoriteFood;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Add Favorite Food');
	        throw new FBException('Add favorite food failed.', 507, $e);
        }
    }

    /**
     * Delete user favorite food
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $id Food log id
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function deleteFavoriteFood($id)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Delete Favorite Food', 'Fitbit API');

        try
        {
	        /** @var SimpleXMLElement|object $result */
	        $result = $this->makeApiRequest('user/-/foods/log/favorite/' . $id, 'DELETE');
	        $timer->stop('Delete Favorite Food');
	        return $result;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Delete Favorite Food');
	        throw new FBException('Delete favorite food failed.', 508, $e);
        }
    }

    /**
     * Get user meal sets
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getMeals()
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Meal Sets', 'Fitbit API');

        try
        {
	        /** @var SimpleXMLElement|object $meals */
	        $meals = $this->makeApiRequest('user/-/meals');
	        $timer->stop('Get Meal Sets');
	        return $meals;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Meal Sets');
	        throw new FBException('Meal request failed.', 509, $e);
        }
    }

    /**
     * Get food units library
     *
     * @access public
     * @version 0.5.2
     *
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getFoodUnits()
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Food Units', 'Fitbit API');

        try
        {
	        /** @var SimpleXMLElement|object $units */
	        $units = $this->makeApiRequest('foods/units');
	        $timer->stop('Get Food Units');
	        return $units;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Food Units');
	        throw new FBException('Food Unit request failed.', 510, $e);
        }
    }

    /**
     * Search for foods in foods database
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $query Search query
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function searchFoods($query)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Search Foods', 'Fitbit API');

        try
        {
	        /** @var SimpleXMLElement|object $foods */
	        $foods = $this->makeApiRequest('foods/search', 'GET', array('query' => $query));
	        $timer->stop('Search Foods');
	        return $foods;
        }
        catch(\Exception $e)
        {
	        $timer->stop('Search Foods');
	        throw new FBException('Food search (for '.$query.') failed.', 511, $e);
        }
    }

    /**
     * Get description of specific food from food db (or private for the user)
     *
     * @access public
     * @version 0.5.2
     *
     * @param  string $id Food Id
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function getFood($id)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Get Food', 'Fitbit API');

        try
        {
	        /** @var SimpleXMLElement|object $food */
	        $food = $this->makeApiRequest('foods/' . $id);
	        $timer->stop('Get Food');
	        return $food;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Get Food');
	        throw new FBException('Food detail request failed.', 512, $e);
        }
    }

    /**
     * Create private foods for a user
     *
     * @access public
     * @version 0.5.2
     *
     * @param string $name Food name
     * @param string $defaultFoodMeasurementUnitId Unit id of the default measurement unit
     * @param string $defaultServingSize Default serving size in measurement units
     * @param string $calories Calories in default serving
     * @param string $description
     * @param string $formType ("LIQUID" or "DRY)
     * @param string $nutrition Array of nutritional values, see http://wiki.fitbit.com/display/API/API-Create-Food
     * @throws FBException
     * @return SimpleXMLElement|object The result as an object or SimpleXMLElement
     */
    public function createFood($name, $defaultFoodMeasurementUnitId, $defaultServingSize, $calories, $description = null, $formType = null, $nutrition = null)
    {
	    /** @var Stopwatch $timer */
	    $timer = new Stopwatch();
	    $timer->start('Create Food', 'Fitbit API');

        $parameters = array();
        $parameters['name'] = $name;
        $parameters['defaultFoodMeasurementUnitId'] = $defaultFoodMeasurementUnitId;
        $parameters['defaultServingSize'] = $defaultServingSize;
        $parameters['calories'] = $calories;
        if (isset($description)) $parameters['description'] = $description;
        if (isset($formType)) $parameters['formType'] = $formType;
        if (isset($nutrition))
        {
            foreach ($nutrition as $i => $value)
            {
                $parameters[$i] = $nutrition[$i];
            }
        }

        try
        {
	        /** @var SimpleXMLElement|object $food */
	        $food = $this->makeApiRequest('foods', 'POST', $parameters);
	        $timer->stop('Create Food');
	        return $food;
        }
        catch (\Exception $e)
        {
	        $timer->stop('Create Food');
	        throw new FBException('Create food failed.', 513, $e);
        }
    }
}
