<?php

namespace TaskForce\Models;

class Task 
{
    private $status;
    private $owner;
    private $freelancer;

    // all possible states & actions
    const STATUS_NEW        = 'new';
    const STATUS_CANCEL     = 'cancelled';
    const STATUS_INPROGRESS = 'inprogress';
    const STATUS_COMPLETE   = 'comlete';
    const STATUS_FAILED     = 'failed';

    const ACTION_CANCEL     = 'cancel'; // заказчик отменил
    const ACTION_RESPOND    = 'respond'; // исполнитель откликнулся
    const ACTION_COMPLETE   = 'complete'; // заказчик принял
    const ACTION_REFUSE     = 'refuse'; // исполнитель отказался
    
    // карта доступных действий при статусах НОВОЕ и В РАБОТЕ
    const AVAILABLE_ACTIONS = [
        self::STATUS_NEW => [self::ACTION_CANCEL, self::ACTION_RESPOND],
        self::STATUS_INPROGRESS => [self::ACTION_COMPLETE, self::ACTION_REFUSE]
    ];
    
    // карта статусов
    private const STATUS_MAP = [
        self::STATUS_NEW        => 'Новое',
        self::STATUS_CANCEL     => 'Отменено',
        self::STATUS_INPROGRESS => 'В работе',
        self::STATUS_COMPLETE   => 'Выполнено',
        self::STATUS_FAILED     => 'Провалено'
    ];
    
    // карта действий
    private const ACTION_MAP = [
        self::ACTION_CANCEL   => 'Отменить',
        self::ACTION_RESPOND  => 'Откликнуться',
        self::ACTION_COMPLETE => 'Принять',
        self::ACTION_REFUSE   => 'Отказаться'
    ];    

    // карта статусов после выполнения указанного действия
    const STATUS_ACTION_RELATION = [
        self::ACTION_CANCEL   => self::STATUS_CANCEL,
        self::ACTION_REFUSE   => self::STATUS_FAILED,
        self::ACTION_COMPLETE => self::STATUS_COMPLETE
    ];
    
    public function __construct(int $owner, int $freelancer)
    {
        $this->owner = $owner;
        $this->freelancer = $freelancer;
        $this->status = self::STATUS_NEW;
    }
    
    // класс имеет методы для возврата «карты» статусов и действий.
    public function getStatusMap(): array
    {
        return self::STATUS_MAP;
    }
    
    public function getActionMap(): array
    {
        return self::ACTION_MAP;
    }

    // метод для получения статуса, в которое задание перейдёт после выполнения указанного действия
    public function getStatus(string $action): ?string
    {
        return self::STATUS_ACTION_RELATION[$action] ?? null;
    }

    // метод для получения доступных действий для указанного статуса    
    public function getAvailableActions(string $status): ?string
    {
        return self::AVAILABLE_ACTIONS[$status] ?? null;
    }
}
