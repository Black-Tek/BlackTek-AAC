<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AccountType: int implements HasColor, HasIcon, HasLabel
{
    case Normal = 1;
    case Tutor = 2;
    case SeniorTutor = 3;
    case GameMaster = 4;
    case CommunityManager = 5;
    case God = 6;

    public function isNormal(): bool
    {
        return $this->value === self::Normal->value;
    }

    public function isTutor(): bool
    {
        return $this->value === self::Tutor->value;
    }

    public function isSeniorTutor(): bool
    {
        return $this->value === self::SeniorTutor->value;
    }

    public function isGameMaster(): bool
    {
        return $this->value === self::GameMaster->value;
    }

    public function isCommunityManager(): bool
    {
        return $this->value === self::CommunityManager->value;
    }

    public function isGod(): bool
    {
        return $this->value === self::God->value;
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Normal => 'Normal',
            self::Tutor => 'Tutor',
            self::SeniorTutor => 'Senior Tutor',
            self::GameMaster => 'Game Master',
            self::CommunityManager => 'Community Manager',
            self::God => 'God',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Normal => 'gray',
            self::Tutor => 'info',
            self::SeniorTutor => 'primary',
            self::GameMaster => 'success',
            self::CommunityManager => 'warning',
            self::God => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Normal => 'heroicon-o-user',
            default => 'heroicon-o-user-group',
        };
    }
}
