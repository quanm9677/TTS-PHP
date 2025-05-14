<?php
require_once __DIR__ . '/AffiliatePartner.php';
/**
 * Lớp cộng tác viên cao cấp (PremiumAffiliatePartner)
 * Kế thừa từ AffiliatePartner, có thêm bonus cố định mỗi đơn hàng.
 */
class PremiumAffiliatePartner extends AffiliatePartner {
    private float $bonusPerOrder;

    public function __construct(string $name, string $email, float $commissionRate, float $bonusPerOrder, bool $isActive = true) {
        parent::__construct($name, $email, $commissionRate, $isActive);
        $this->bonusPerOrder = $bonusPerOrder;
    }

    public function calculateCommission(float $orderValue): float {
        return parent::calculateCommission($orderValue) + $this->bonusPerOrder;
    }

    public function getSummary(): string {
        return parent::getSummary() . sprintf(" | Bonus/đơn: %.0f VNĐ", $this->bonusPerOrder);
    }
} 