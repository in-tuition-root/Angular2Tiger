<?php
/*
 * UserProfile
 */
namespace InTution\lib\Models;

/*
 * UserProfile
 */
class UserProfile {
    /* @var string $createdAt  */
    public $createdAt;
    /* @var string $mobileNumber Mobile Number of the Referral Deal user. */
    public $mobileNumber;
    /* @var string $name First name of the Referral Deal user. */
    public $name;
    /* @var Bool $defaultProfile  */
    public $defaultProfile;
    /* @var Bool $defaultProfileImage  */
    public $defaultProfileImage;
    /* @var string $description  */
    public $description;
    /* @var string $email Email address of the Referral Deal user */
    public $email;
    /* @var string $picture Image URL of the Referral Deal user. */
    public $picture;
    /* @var string $gender Gender of the user. */
    public $gender;
    /* @var \DateTime $dateOfBirth User&#39;s date of birth. */
    public $dateOfBirth;
    /* @var \SwaggerServer\lib\Models\Address $address  */
    public $address;
    
}
