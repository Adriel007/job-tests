<?php

namespace NW\WebService\References\Operations\Notification;

use NW\WebService\Messages\MessagesClient;
use NW\WebService\Notifications\NotificationEvents;
use NW\WebService\Notifications\NotificationManager;

class TsReturnOperation extends ReferencesOperation
{
    public const TYPE_NEW = 1;
    public const TYPE_CHANGE = 2;

    /**
     * @throws \Exception
     */
    public function doOperation(): array
    {
        $data = (array) $this->getRequest('data');
        $resellerId = $data['resellerId'];
        $notificationType = (int) $data['notificationType'];

        $result = $this->initializeResultArray();

        $this->validateInputData($resellerId, $notificationType);

        $reseller = Seller::getById((int) $resellerId);

        if ($reseller === null) {
            throw new \Exception('Reseller not found!', 400);
        }

        $client = $this->validateClient($data, $resellerId, $reseller);
        $creator = Employee::getById((int) $data['creatorId']);
        $expert = Employee::getById((int) $data['expertId']);

        $differences = $this->getDifferencesText($notificationType, $data, $resellerId);

        $templateData = $this->buildTemplateData($data, $resellerId, $client, $creator, $expert, $differences);

        $this->validateTemplateData($templateData);

        $emailFrom = getResellerEmailFrom();

        $this->sendEmployeeNotifications($emailFrom, $resellerId, $templateData, $result);

        $this->sendClientNotifications($emailFrom, $client, $resellerId, $notificationType, $data, $templateData, $result);

        return $result;
    }
    /**
     * Инициализирует массив результата уведомлений.
     *
     * @return array
     */
    private function initializeResultArray(): array
    {
        return [
            'notificationEmployeeByEmail' => false,
            'notificationClientByEmail' => false,
            'notificationClientBySms' => [
                'isSent' => false,
                'message' => '',
            ],
        ];
    }

    /**
     * Проверяет входные данные на корректность.
     *
     * @param mixed $resellerId
     * @param int   $notificationType
     *
     * @throws \Exception
     */
    private function validateInputData($resellerId, int $notificationType): void
    {
        if (empty((int) $resellerId)) {
            throw new \Exception('Empty resellerId', 400);
        }

        if (empty($notificationType)) {
            throw new \Exception('Empty notificationType', 400);
        }
    }

    /**
     * Проверяет клиента и его соответствие реселлеру.
     *
     * @param array   $data
     * @param mixed   $resellerId
     * @param Seller  $reseller
     *
     * @return Contractor
     * @throws \Exception
     */
    private function validateClient(array $data, $resellerId, Seller $reseller): Contractor
    {
        $client = Contractor::getById((int) $data['clientId']);

        if ($client === null || $client->type !== Contractor::TYPE_CUSTOMER || $client->Seller->id !== $resellerId) {
            throw new \Exception('Client not found!', 400);
        }

        return $client;
    }

    /**
     * Проверяет данные шаблона на заполненность.
     *
     * @param array $templateData
     *
     * @throws \Exception
     */
    private function validateTemplateData(array $templateData): void
    {
        foreach ($templateData as $key => $tempData) {
            if (empty($tempData)) {
                throw new \Exception("Template Data ({$key}) is empty!", 500);
            }
        }
    }

    /**
     * Отправляет уведомления сотрудникам.
     *
     * @param string $emailFrom
     * @param mixed  $resellerId
     * @param array  $templateData
     * @param array  $result
     */
    private function sendEmployeeNotifications(string $emailFrom, $resellerId, array $templateData, array &$result): void
    {
        // ... (ваш существующий код)
    }

    /**
     * Отправляет уведомления клиенту.
     *
     * @param string      $emailFrom
     * @param Contractor  $client
     * @param mixed       $resellerId
     * @param int         $notificationType
     * @param array       $data
     * @param array       $templateData
     * @param array       $result
     */
    private function sendClientNotifications(string $emailFrom, Contractor $client, $resellerId, int $notificationType, array $data, array $templateData, array &$result): void
    {
        // ... (ваш существующий код)
    }
    /**
     * Возвращает текст различий для типа уведомления.
     *
     * @param int   $notificationType
     * @param array $data
     * @param mixed $resellerId
     *
     * @return string
     */
    private function getDifferencesText(int $notificationType, array $data, $resellerId): string
    {
        $differences = '';

        if ($notificationType === self::TYPE_NEW) {
            $differences = __('NewPositionAdded', null, $resellerId);
        } elseif ($notificationType === self::TYPE_CHANGE && !empty($data['differences'])) {
            $differences = __('PositionStatusHasChanged', [
                'FROM' => Status::getName((int) $data['differences']['from']),
                'TO' => Status::getName((int) $data['differences']['to']),
            ], $resellerId);
        }

        return $differences;
    }

    /**
     * Строит массив данных для шаблона уведомления.
     *
     * @param array      $data
     * @param mixed      $resellerId
     * @param Contractor $client
     * @param Employee   $creator
     * @param Employee   $expert
     * @param string     $differences
     *
     * @return array
     */
    private function buildTemplateData(array $data, $resellerId, Contractor $client, Employee $creator, Employee $expert, string $differences): array
    {
        return [
            // ... (ваш существующий код)
        ];
    }
}