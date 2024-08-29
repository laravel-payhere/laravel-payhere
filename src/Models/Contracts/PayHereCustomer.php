<?php

declare(strict_types=1);

namespace PayHere\Models\Contracts;

interface PayHereCustomer
{
    /**
     * Get the first name of the customer.
     */
    public function payHereFirstName(): ?string;

    /**
     * Get the last name of the customer.
     */
    public function payHereLastName(): ?string;

    /**
     * Get the email address of the customer.
     */
    public function payHereEmail(): ?string;

    /**
     * Get the phone number of the customer.
     */
    public function payHerePhone(): ?string;

    /**
     * Get the address of the customer.
     */
    public function payHereAddress(): ?string;

    /**
     * Get the city of the customer.
     */
    public function payHereCity(): ?string;

    /**
     * Get the country of the customer.
     */
    public function payHereCountry(): ?string;
}
