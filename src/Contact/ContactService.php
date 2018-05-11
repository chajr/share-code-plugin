<?php
namespace GrShareCode\Contact;

use GrShareCode\GetresponseApi;
use GrShareCode\GetresponseApiException;

/**
 * Class ContactService
 * @package GrShareCode\Contact
 */
class ContactService
{
    /** @var GetresponseApi */
    private $getresponseApi;

    /**
     * @param GetresponseApi $getresponseApi
     */
    public function __construct(GetresponseApi $getresponseApi)
    {
        $this->getresponseApi = $getresponseApi;
    }

    /**
     * @param string $email
     * @param string $listId
     * @return Contact
     * @throws ContactNotFoundException
     * @throws GetresponseApiException
     */
    public function getContactByEmail($email, $listId)
    {
        $response = $this->getresponseApi->getContactByEmail($email, $listId);

        if (empty($response)) {
            throw new ContactNotFoundException();
        }

        return new Contact(
            $response['contactId'],
            $response['name'],
            $response['email']
        );
    }

    /**
     * @param AddContactCommand $subscriber
     * @throws GetresponseApiException
     */
    public function sendContact(AddContactCommand $subscriber)
    {
        $params = [
            'name' => $subscriber->getName(),
            'email' => $subscriber->getEmail(),
            'dayOfCycle' => $subscriber->getDayOfCycle(),
            'campaign' => [
                'campaignId' => $subscriber->getListId(),
            ]
        ];

        /** @var CustomField $customField */
        foreach ($subscriber->getCustomFieldsCollection() as $customField) {
            $params['customFieldValues'][] = [
                'customFieldId' => $customField->getId(),
                'value' => [$customField->getValue()]
            ];
        }

        $this->getresponseApi->createContact($params);
    }
}
