<?php
namespace App\Platform;

interface PlatformInterface
{
    /**
     * 
     * get platform name
     * 
     * @return string
     */
    public function getPlatformName();
    /**
     * 
     * get platform url
     * 
     * @return string
     */
    public function getPlatformUrl();
    /**
     * 
     * get platform api url
     * 
     * @return string
     */
    public function getPlatformApiUrl();

    /**
     * 
     * get platform client id
     * 
     * @return string
     */
    public function getPlatformClientId();

    /**
     * 
     * get platform client secret
     * 
     * @return string
     */
    public function getPlatformClientSecret();

    /**
     * 
     * get platform account id
     * 
     * @return string
     */
    public function getPlatformAccountId();

    /**
     * 
     * get platform token
     * 
     * @return string
     */
    public function getToken();




}