<?php

class Task {

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

    // Карта — это ассоциативный массив, где ключ — внутреннее имя, 
    //а значение — названия статуса/действия на русском.
    
    // карта статусов
    const STATUS_MAP = [
        self::STATUS_NEW = 'Новое';
        self::STATUS_CANCEL = 'Отменено';
        self::STATUS_INPROGRESS = 'В работе';
        self::STATUS_COMPLETE = 'Выполнено';
        self::STATUS_FAILED = 'Провалено';
    ];
    
    // карта действий
    const ACTION_MAP = [
        self::ACTION_PUBLISH = 'Опубликовать';
        self::ACTION_CANCEL = 'Отменить';
        self::ACTION_RESPOND = 'Откликнуться';
        self::ACTION_COMPLETE = 'Принять';
        self::ACTION_REFUSE = 'Отказаться';
    ];

    // класс имеет методы для возврата «карты» статусов и действий.
    // сюда надо параметр передавать? Чтобы вернуть название на русском
    public function getStatusMap(status){
        return self::STATUS_MAP[status];
    }
    //  сюда надо параметр передавать?
    public function getActionMap($action){
        return self::ACTION_MAP[action];
    }

    // карта доступных действий при статусах НОВОЕ и В РАБОТЕ
    const AVAILABLE_ACTIONS = [
        self::STATUS_NEW => [self::ACTION_CANCEL, self::ACTION_RESPOND],
        self::STATUS_INPROGRESS => [self::ACTION_COMPLETE, self::ACTION_REFUSE]
    ];

    // карта статусов после выполнения указанного действия
    const GET_STATUS = [
        // не уверена как сделать стутус NEW при создании задания
        // может так?
        self::ACTION_PUBLISH => self::STATUS_NEW,
        self::ACTION_CANCEL => self::STATUS_CANCEL,

        // не уверена насчет этого. "В работе - Заказчик выбрал исполнителя для задания"
        self::ACTION_RESPOND => self::STATUS_INPROGRESS,

        self::ACTION_REFUSE => self::STATUS_FAILED,
        self::ACTION_COMPLETE => self::STATUS_COMPLETE
    ];

    public function __construct($owner, $freelancer, $status ){
        $this->owner = $owner;
        $this->freelancer = $freelancer;
        $this->status = $status;
    }

    // метод для получения статуса, в которой он перейдёт после выполнения указанного действия
    public function getStatus($action){
        return self::GET_STATUS[$action];
    }

    // метод для получения доступных действий для указанного статуса    
    public function getAvailableActions($status){
        return self::AVAILABLE_ACTIONS[$status];
    }

}