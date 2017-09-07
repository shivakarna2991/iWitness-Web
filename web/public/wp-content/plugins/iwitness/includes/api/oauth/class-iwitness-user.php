<?php

class iWitness_User
{

    public $id;
    public $phone;
    public $phoneAlt;
    public $firstName;
    public $lastName;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $zip;
    public $email;
    public $gender;
    public $birthDate;
    public $heightFeet;
    public $heightInches;
    public $weight;
    public $eyeColor;
    public $hairColor;
    public $ethnicity;
    public $distFeature;
    public $timezone;
    public $flags;
    public $created;
    public $modified;
    public $isDeleted;
    public $type;
    public $photoUrl;
    public $eventsUrl;
    public $subscriptionStartAt;
    public $subscriptionExpireAt;
    public $subscriptionId;
    public $suspended;


    public function __construct($data = array())
    {
        if ($data && is_array($data)) {
            $this->parse_from($data);
        }
    }

    protected function parse_from($data)
    {
        if (isset($data['_embedded']['user'][0])) {
            $this->exchange_array($data['_embedded']['user'][0]);
        } else {
            $this->exchange_array($data);
        }
    }

    /**
     * @param array $data
     * @return $this
     */
    public function exchange_array(array $data)
    {
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'id':
                    $this->id = $value;
                    break;
                case 'phone':
                    $this->phone = $value;
                    break;
                case 'phoneAlt':
                    $this->phoneAlt = $value;
                    break;
                case 'firstName':
                    $this->firstName = $value;
                    break;
                case 'lastName':
                    $this->lastName = $value;
                    break;
                case 'address1':
                    $this->address1 = $value;
                    break;
                case 'address2':
                    $this->address2 = $value;
                    break;
                case 'city':
                    $this->city = $value;
                    break;
                case 'state':
                    $this->state = $value;
                    break;
                case 'zip':
                    $this->zip = $value;
                    break;
                case 'email':
                    $this->email = $value;
                    break;
                case 'gender':
                    $this->gender = $value;
                    break;
                case 'birthDate':
                    $this->birthDate = $value;
                    break;
                case 'heightFeet':
                    $this->heightFeet = $value;
                    break;
                case 'heightInches':
                    $this->heightInches = $value;
                    break;
                case 'weight':
                    $this->weight = $value;
                    break;
                case 'eyeColor':
                    $this->eyeColor = $value;
                    break;
                case 'hairColor':
                    $this->hairColor = $value;
                    break;
                case 'ethnicity':
                    $this->ethnicity = $value;
                    break;
                case 'distFeature':
                    $this->distFeature = $value;
                    break;
                case 'timezone':
                    $this->timezone = $value;
                    break;
                case 'flags':
                    $this->flags = $value;
                    break;
                case 'created':
                    $this->created = $value;
                    break;
                case 'modified':
                    $this->modified = $value;
                    break;
                case 'deleted':
                    $this->isDeleted = $value;
                    break;
                case 'type':
                    $this->type = $value;
                    break;
                case 'photoUrl':
                    $this->photoUrl = $value;
                    break;
                case 'eventsUrl':
                    $this->eventsUrl = $value;
                    break;
                case 'subscriptionStartAt' :
                    $this->subscriptionStartAt = $value;
                    break;
                case 'subscriptionExpireAt' :
                    $this->subscriptionExpireAt = $value;
                    break;
                case 'subscriptionId' :
                    $this->subscriptionId = $value;
                    break;
                case 'suspended' :
                    $this->suspended = $value;
                    break;


            }
        }
        return $this;
    }

    /**
     * @param $json
     * @return iWitness_User
     */
    public static function deserialize($json)
    {
        $data = json_decode($json, true);
        return new self($data);
    }

    /**
     * @return string
     */
    public static function get_anonymous_profile_image()
    {
        return get_bloginfo('template_directory') . '/images/anonymous.png';
    }

    /**
     * @param $name
     * @return mixed
     * @throws OutOfRangeException
     */
    public function __get($name)
    {
        if (!property_exists($this, $name)) {
            throw new \OutOfRangeException(sprintf(
                '%s does not contain a property by the name of "%s"',
                __CLASS__,
                $name
            ));
        }

        return $this->{$name};
    }

    /**
     * @param $property
     * @param $value
     * @return $this
     * @throws OutOfRangeException
     */
    public function __set($property, $value)
    {
        if (!property_exists($this, $property)) {
            throw new \OutOfRangeException(sprintf(
                '%s does not contain a property by the name of "%s"',
                __CLASS__,
                $property
            ));
        }

        $this->$property = $value;

        return $this;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return (property_exists($this, $name));
    }

    /**
     * @return mixed|string|void
     */
    public function  serialize()
    {
        return json_encode($this->get_array_copy());
    }

    /**
     * @return array
     */
    public function get_array_copy()
    {
        return array(
            "id" => $this->id,
            "phone" => $this->phone,
            "phoneAlt" => $this->phoneAlt,
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "address1" => $this->address1,
            "address2" => $this->address2,
            "city" => $this->city,
            "state" => $this->state,
            "zip" => $this->zip,
            "email" => $this->email,
            "gender" => $this->gender,
            "birthDate" => $this->birthDate,
            "heightFeet" => $this->heightFeet,
            "heightInches" => $this->heightInches,
            "weight" => $this->weight,
            "eyeColor" => $this->eyeColor,
            "hairColor" => $this->hairColor,
            "ethnicity" => $this->ethnicity,
            "distFeature" => $this->distFeature,
            "timezone" => $this->timezone,
            "flags" => $this->flags,
            "created" => $this->created,
            "modified" => $this->modified,
            "deleted" => $this->isDeleted,
            "type" => $this->type,
            "photoUrl" => $this->photoUrl,
            "eventsUrl" => $this->eventsUrl,
            'subscriptionExpireAt' => $this->subscriptionExpireAt,
            'subscriptionStartAt' => $this->subscriptionStartAt,
            'subscriptionId' => $this->subscriptionId,
            'suspended' => $this->suspended
        );
    }

    /**
     * @return bool
     */
    public function isFree()
    {
        if ($this->subscriptionId && $this->subscriptionExpireAt == 0) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function hasExpired()
    {
        if ($this->isAdmin()) {
            return false;
        }

        if ($this->subscriptionExpireAt == 0) {
            return false; //never expire account
        }

        if ($this->subscriptionId && $this->subscriptionExpireAt < time()) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type == 'Admin';
    }

    /**
     * Get user image, if cannot find user image then the default image will be returned
     *
     * @return string
     */
    public function get_user_image()
    {
        return esc_url(!empty($this->photoUrl) ? $this->photoUrl : self::get_anonymous_profile_image());
    }

    /**
     * Get user full-name
     *
     * @return string
     */
    public function get_full_name()
    {
        return isset($this->firstName) && isset($this->lastName) ? esc_html($this->firstName . ' ' . $this->lastName) : 'N/A';
    }

    /**
     * Get full address
     *
     * @return string
     */
    public function get_address()
    {
        $result = null;
        if ($this->address1 || $this->city || $this->state || $this->zip) {
            $result = esc_html($this->address1) . ' ' . esc_html($this->address2) . '<br>' . esc_html($this->city) . ' ';
            $result = $result . esc_html($this->state) . ' ';
            $result = $result . esc_html(iwitness_view_helper_decorate(', ', $this->zip));
        } else {
            $result = 'N/A';
        }
        return $result;
    }

    /**
     * Get wireless number
     *
     * @return string
     */
    public function get_wireless_number()
    {
        return esc_html($this->phone);
    }

    /**
     * Get Email address
     *
     * @return string
     */
    public function get_email()
    {
        return esc_html($this->email);
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function get_gender()
    {
        return isset($this->gender) ? esc_html((1 == $this->gender) ? 'male' : 'female') : 'N/A';
    }

    /**
     * Get date of birth
     *
     * @return string
     */
    public function get_birthday()
    {
        return isset($this->birthDate) ? esc_html(substr(date("Ymd") - date("Ymd", $this->birthDate), 0, -4)) : 'N/A';
    }

    /**
     * Get height
     *
     * @return null|string
     */
    public function get_height()
    {
        $result = null;
        if (isset($this->heightInches) || isset($this->heightFeet)) {
            $result = esc_html(iwitness_view_helper_decorate('', $this->heightFeet, ' ft')) . ' ';
            $result = $result . esc_html(iwitness_view_helper_decorate('', $this->heightInches, ' in'));
        } else {
            $result = 'N/A';
        }

        return $result;
    }

    /**
     * Get Weight
     *
     * @return string
     */
    public function get_weight()
    {
        return isset($this->weight) ? esc_html($this->weight) . ' lb' : 'N/A';
    }

    /**
     * Get ethnicity
     *
     * @return string
     */
    public function get_ethnicity()
    {
        return (isset($this->ethnicity) && 'Other' != $this->ethnicity) ? esc_html($this->ethnicity) : 'N/A';
    }

    /**
     * Get eyes color
     *
     * @return string
     */
    public function get_eyes_color()
    {
        return isset($this->eyeColor) ? esc_html($this->eyeColor) : 'N/A';
    }

    /**
     * Get hair color
     *
     * @return string
     */
    public function get_hair_color()
    {
        return isset($this->hairColor) ? esc_html($this->hairColor) : 'N/A';
    }

    /**
     * Get distance of features
     *
     * @return string
     */
    public function get_dist_features()
    {
        return isset($this->distFeature) ? esc_html($this->distFeature) : 'N/A';
    }

}