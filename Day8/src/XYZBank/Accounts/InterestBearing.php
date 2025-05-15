<?php
namespace XYZBank\Accounts;

/**
 * Interface InterestBearing
 * Interface cho các tài khoản có sinh lãi.
 */
interface InterestBearing
{
    /**
     * Tính lãi suất hàng năm.
     *
     * @return float Lãi suất hàng năm
     */
    public function calculateAnnualInterest(): float;
}
