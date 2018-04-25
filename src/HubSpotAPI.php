<?php

namespace TimOrd\HubSpotAPI;

use Zttp\Zttp;

class HubSpotAPI {

	private $apiKey = false;
	private $endpoint = 'https://api.hubapi.com/contacts/v1/contact/createOrUpdate/email';
	public $firstName    = false;
	public $lastName     = false;
	public $emailAddress = false;
	public $phoneNumber  = false;

	public function setApiKey($apiKey)
	{
		
		$this->apiKey = $apiKey;
		
		return $this;
		
	}

	public function setFirstName($firstName)
	{

		$this->firstName = $firstName;
	
		return $this;

	}

	public function setLastName($lastName)
	{

		$this->lastName = $lastName;
	
		return $this;

	}

	public function setEmailAddress($emailAddress)
	{

		$this->emailAddress = $emailAddress;
	
		return $this;

	}

	public function setPhoneNumber($phoneNumber)
	{

		$this->phoneNumber = $phoneNumber;
	
		return $this;

	}

	public function send()
	{

		if (!$this->apiKey || !$this->firstName) {
			throw new InvalidArgumentException("An api key and first name is the minimum fields required to make a lead");
		}

		$url = sprintf("%s/%s/?hapikey=%s", $this->endpoint, $this->emailAddress, $this->apiKey);
	
		$fields = array( 
            'properties' => array(
                array(
                    'property' => 'firstname',
                    'value'    => $this->firstName
                ),
                array(
                    'property' => 'lastname',
                    'value'    => $this->lastName
                ),
                array(
                    'property' => 'phone',
                    'value'    => $this->phoneNumber
                ),
            ),
        );

        $response = Zttp::post($url, $fields);

        return $response->isOk();
        
    }
}
?>