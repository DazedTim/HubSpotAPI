<?php

namespace TimOrd\HubSpotAPI;

use Zttp\Zttp;

class HubSpotAPI {

	private $apiKey = false;

	private $endpoint = 'https://api.hubapi.com/contacts/v1/contact/createOrUpdate/email';

	private $emailAddress = false;

	public $fields = array();

	public function setApiKey($apiKey)
	{
		
		$this->apiKey = $apiKey;
		
		return $this;
		
	}

	public function setEmailAddress($emailAddress)
	{

		$this->emailAddress = $emailAddress;
	
		return $this;

	}

	public function setFirstName($firstName)
	{

		$this->setField('firstname', $firstName);
	
		return $this;

	}

	public function setLastName($lastName)
	{

		$this->setField('lastname', $lastName);
	
		return $this;

	}


	public function setPhoneNumber($phoneNumber)
	{
		$this->setField('phone', $phoneNumber);
	
		return $this;

	}

	public function setField($key, $value)
	{

		$this->fields[$key] = $value;
		
		return $this;
	}

	public function setFields($fields)
	{

		foreach ($fields as $key => $value ){
			$this->setField($key, $value);
		}
		
		return $this;
	}

	public function send()
	{

		if (! $this->apiKey || ! $this->emailAddress || ! isset($this->fields['firstname'])) {
			throw new InvalidArgumentException("An api key, email address and first name are the minimum fields required to make a lead.");
		}

		$url = sprintf("%s/%s/?hapikey=%s", $this->endpoint, $this->emailAddress, $this->apiKey);

		$fields = array();

		foreach ($this->fields as $key => $value) {
			$fields['properties'][] = array(
				'property' => $key,
				'value'    => $value
			);
		}

		$response = Zttp::post($url, $fields);

		return $response->isOk();
		
	}
}
?>