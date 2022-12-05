<?php

namespace App\Modules\Common\Domain;

class Payload
{
    /** A creation command succeeded. */
    const STATUS_CREATED = 'CREATED';
    /** A deletion command succeeded. */
    const STATUS_DELETED = 'DELETED';
    /** There was a major error of some sort. */
    const STATUS_ERROR = 'ERROR';
    /** A query successfully returned results. */
    const STATUS_FOUND = 'FOUND';
    /** A new object is being returned. */
    const STATUS_NEW = 'NEW';
    /** A creation command failed. */
    const STATUS_NOT_CREATED = 'NOT_CREATED';
    /** A deletion command failed. */
    const STATUS_NOT_DELETED = 'NOT_DELETED';
    /** A query failed to return results. */
    const STATUS_NOT_FOUND = 'NOT_FOUND';
    /** A query failed to return results. */
    const STATUS_NOT_FOUND_PARAMS = 'NOT_FOUND_PARAMS';
    /** A email failed to return results. */
    const STATUS_EMAIL_NOT_FOUND = 'EMAIL_NOT_FOUND';
    /** An update command failed. */
    const STATUS_NOT_UPDATED = 'NOT_UPDATED';
    /** User input was not valid. */
    const STATUS_NOT_VALID = 'NOT_VALID';
    /** An update command succeeded. */
    const STATUS_UPDATED = 'UPDATED';
    /** User input was valid. */
    const STATUS_VALID = 'VALID';
    /** User login success. */
    const STATUS_AUTHENTICATED = 'AUTHENTICATED';
    /** User login fail. */
    const STATUS_AUTH_FAILED = 'AUTH_FAILED';
    /** User validate email success. **/
    const STATUS_AUTH_VERIFY_SUCCESS= 'VERIFIED';
    /** User already validate email. **/
    const STATUS_AUTH_VERIFY_ALREADY = 'ALREADY_VERIFIED';
    /** User validate email fail. **/
    const STATUS_AUTH_VERIFY_FAILED = 'VERIFIED_FAILED';
    /** User resend email validation. **/
    const STATUS_AUTH_VERIFY_RESEND = 'RESEND_VERIFIED';
    /** User forget password. **/
    const STATUS_AUTH_FORGET_PASSWORD = 'FORGET_PASSWORD';
    /** User reset password failed. **/
    const STATUS_AUTH_RESET_PASSWORD_FAILED = 'RESET_PASSWORD_FAILED';
    /** User reset password success. **/
    const STATUS_AUTH_RESET_PASSWORD_SUCCESS = 'RESET_PASSWORD_SUCCESS';
    /** User change password failed. */
    const STATUS_AUTH_CHANGE_PASSWORD_FAILED = 'CHANGE_PASSWORD_FAILED';
    /** User change password success. */
    const STATUS_AUTH_CHANGE_PASSWORD_SUCCESS = 'CHANGE_PASSWORD_SUCCESS';
    /** User logout. */
    const STATUS_LOGOUT = 'LOGOUT';
    /** Unauthorized User. */
    const STATUS_UNAUTHORIZED = 'UNAUTHORIZED';
    /** User Not Validate. */
    const STATUS_FORBIDDEN = 'FORBIDDEN';
    /** Custom Response **/
    const STATUS_CUSTOM = 'CUSTOM';

    public function __construct(string $status, array $result = [])
    {
        $this->status = $status;
        $this->result = $result;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getResult(): array
    {
        return $this->result;
    }
}
