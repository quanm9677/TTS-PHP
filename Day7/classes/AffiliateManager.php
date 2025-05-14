<?php
require_once __DIR__ . '/AffiliatePartner.php';
/**
 * Lớp quản lý danh sách cộng tác viên (AffiliateManager)
 */
class AffiliateManager {
    private array $partners = [];

    public function addPartner(AffiliatePartner $affiliate): void {
        $this->partners[] = $affiliate;
    }

    public function listPartners(): void {
        foreach ($this->partners as $partner) {
            echo $partner->getSummary() . "\n";
        }
    }

    public function totalCommission(float $orderValue): float {
        $total = 0;
        foreach ($this->partners as $partner) {
            $total += $partner->calculateCommission($orderValue);
        }
        return $total;
    }

    public function getPartners(): array {
        return $this->partners;
    }

    public function getActivePartners(): array {
        return array_filter($this->partners, function($partner) {
            return $partner->isActive();
        });
    }
}
