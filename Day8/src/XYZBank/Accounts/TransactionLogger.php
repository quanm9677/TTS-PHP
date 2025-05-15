<?php
namespace XYZBank\Accounts;

/**
 * Trait TransactionLogger
 * Trait để ghi log các giao dịch gửi/rút tiền.
 */
trait TransactionLogger {
    /**
     * Ghi log giao dịch.
     *
     * @param string $type Loại giao dịch (Gửi/Rút)
     * @param float $amount Số tiền giao dịch
     * @param float $newBalance Số dư mới sau giao dịch
     */
    public function logTransaction(string $type, float $amount, float $newBalance): void {
        echo sprintf(
            "[%s] Giao dịch: %s tiền %.0f VNĐ | Số dư mới: %.0f VNĐ\n",
            date('Y-m-d H:i:s'),
            $type,
            $amount,
            $newBalance
        );
    }
}