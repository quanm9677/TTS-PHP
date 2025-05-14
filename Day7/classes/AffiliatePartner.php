<?php
/**
 * Lớp cơ bản cho cộng tác viên (AffiliatePartner)
 * Đại diện cho cộng tác viên phổ thông.
 */
class AffiliatePartner {
    const PLATFORM_NAME = "VietLink Affiliate";
    private string $name;
    private string $email;
    protected float $commissionRate;
    protected bool $isActive;

    public function __construct(string $name, string $email, float $commissionRate, bool $isActive = true) {
        $this->name = $name;
        $this->email = $email;
        $this->commissionRate = $commissionRate;
        $this->isActive = $isActive;
    }

    // public function __destruct() {
    //     echo "[LOG] CTV '{$this->name}' đã bị hủy khỏi bộ nhớ.\n";
    // }

    public function calculateCommission(float $orderValue): float {
        return $orderValue * $this->commissionRate / 100;
    }

    public function getSummary(): string {
        return sprintf(
            "Tên: %s | Email: %s | Tỷ lệ hoa hồng: %.2f%% | Trạng thái: %s | Nền tảng: %s",
            $this->name,
            $this->email,
            $this->commissionRate,
            $this->isActive ? 'Đang hoạt động' : 'Ngừng hoạt động',
            self::PLATFORM_NAME
        );
    }

    public function isActive(): bool {
        return $this->isActive;
    }
} 