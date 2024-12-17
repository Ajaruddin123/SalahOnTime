<?php

namespace App\Contracts;

interface AuthInterface
{
    /**     
     * @param array $data
     * @return void
     */
    public function register(array $data);

    /**     
     * @param string $email
     * @param string $otp
     * @param string|null|boolean $rememberToken
     * @return void
     */
    public function loginWithEmail(string $email, string $password, string|null|bool $rememberToken = false);

    /**  
     * @param string $email
     * @param string $otp
     * @param string|null|boolean $rememberToken
     * @return void
     */
    public function loginWithMobileNumber(int $mobileNumber, string $password, string|null|bool $rememberToken = false);


    public function logout();
};
