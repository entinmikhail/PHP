<?php

define('TOKEN_FILE', 'token_info.json');


use AmoCRM\OAuth2\Client\Provider\AmoCRM;
use AmoCRM\OAuth2\Client\Provider\AmoCRMResourceOwner;
use League\OAuth2\Client\Token\AccessToken;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Collections\NullTagsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Filters\LeadsFilter;
use AmoCRM\Models\CompanyModel;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\NullCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use League\OAuth2\Client\Token\AccessTokenInterface;
use AmoCRM\Models\CatalogElementModel;
use AmoCRM\Models\Customers\CustomerModel;
use AmoCRM\Collections\CompaniesCollection;
use AmoCRM\Collections\CustomFields\CustomFieldEnumsCollection;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Collections\CustomFields\CustomFieldsCollection;
use AmoCRM\Models\CustomFields\CheckboxCustomFieldModel;
use AmoCRM\Models\CustomFields\CustomFieldModel;
use AmoCRM\Models\CustomFields\EnumModel;
use AmoCRM\Models\CustomFields\SelectCustomFieldModel;
use AmoCRM\Models\CustomFields\MultitextCustomFieldModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultiselectCustomFieldValueModel;
use AmoCRM\Models\CustomFields;
use AmoCRM\Collections\CustomFields\CustomFieldRequiredStatusesCollection;
use AmoCRM\Models\BaseApiModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultiselectCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\MultiselectCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues;
use AmoCRM\Models\CustomFields\TextCustomFieldModel;




include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/vendor/amocrm/oauth2-amocrm/src/AmoCRM.php';

session_start();
$baseDomain = 'msha3212.amocrm.ru';

$provider = new AmoCRM([
    'clientId' => '3a71564e-542d-469f-ac27-39acaeeb6c15',
    'clientSecret' => 'O0wggkDOHlO99WgSUskgszcAt5zOEBY6mEWm5lLSwrtMKlPoT2Td4rgxc77gGDTG',
    'redirectUri' => 'https://shadowrazezxcqwe.000webhostapp.com/example22.php',
    'baseDomain' => 'msha3212.amocrm.ru',
]);

if (isset($_GET['referer'])) {
    $provider->setBaseDomain($_GET['referer']);
}

if (!isset($_GET['request'])) {
    if (!isset($_GET['code'])) {
        $_SESSION['oauth2state'] = bin2hex(random_bytes(16));
        if (true) {
            echo '<div>
                <script
                    class="amocrm_oauth"
                    charset="utf-8"
                    data-client-id="' . $provider->getClientId() . '"
                    data-title="Установить интеграцию"
                    data-compact="false"
                    data-class-name="className"
                    data-color="default"
                    data-state="' . $_SESSION['oauth2state'] . '"
                    data-error-callback="handleOauthError"
                    src="https://www.amocrm.ru/auth/button.min.js"
                ></script>
                </div>';
            echo '<script>
            handleOauthError = function(event) {
                alert(\'ID клиента - \' + event.client_id + \' Ошибка - \' + event.error);
            }
            </script>';
            die;
        } else {
            $authorizationUrl = $provider->getAuthorizationUrl(['state' => $_SESSION['oauth2state']]);
            header('Location: ' . $authorizationUrl);
        }
    } elseif (empty($_GET['state']) || empty($_SESSION['oauth2state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
        exit('Invalid state');
    }
    try {
        $accessToken = $provider->getAccessToken(new League\OAuth2\Client\Grant\AuthorizationCode(), [
            'code' => $_GET['code'],
        ]);

        if (!$accessToken->hasExpired()) {
            saveToken([
                'accessToken' => $accessToken->getToken(),
                'refreshToken' => $accessToken->getRefreshToken(),
                'expires' => $accessToken->getExpires(),
                'baseDomain' => $provider->getBaseDomain(),
            ]);
        }
    } catch (Exception $e) {
        die((string)$e);
    }
    $ownerDetails = $provider->getResourceOwner($accessToken);

    //printf('Hello, %s!', $ownerDetails->getName());

} else {
    $accessToken = getToken();

    $provider->setBaseDomain($accessToken->getValues()['baseDomain']);


    if ($accessToken->hasExpired()) {
        try {
            $accessToken = $provider->getAccessToken(new League\OAuth2\Client\Grant\RefreshToken(), [
                'refresh_token' => $accessToken->getRefreshToken(),
            ]);

            saveToken([
                'accessToken' => $accessToken->getToken(),
                'refreshToken' => $accessToken->getRefreshToken(),
                'expires' => $accessToken->getExpires(),
                'baseDomain' => $provider->getBaseDomain(),
            ]);

        } catch (Exception $e) {
            die((string)$e);
        }
    }

    $token = $accessToken->getToken();

    try {
        $data = $provider->getHttpClient()
            ->request('GET', $provider->urlAccount() . 'api/v2/account', [
                'headers' => $provider->getHeaders($accessToken)
            ]);
        $parsedBody = json_decode($data->getBody()->getContents(), true);
        printf('ID аккаунта - %s, название - %s', $parsedBody['id'], $parsedBody['name']);
    } catch (GuzzleHttp\Exception\GuzzleException $e) {
        var_dump((string)$e);
    }
}



$clientId = '3a71564e-542d-469f-ac27-39acaeeb6c15';
$clientSecret = 'Bw3BHiMbvtXJylBDb6wkDVUUP5wr43VW5FUvYK1a6OTWbkk7nqYqDPkO5NHxPJUX';
$redirectUri = 'https://shadowrazezxczxc.000webhostapp.com/example22.phpp';
$apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
$apiClient->setAccountBaseDomain($baseDomain);

$apiClient->setAccessToken($accessToken)
    ->onAccessTokenRefresh(
        function (\League\OAuth2\Client\Token\AccessTokenInterface $accessToken, string $baseDomain) {
            saveToken(
                [
                    'accessToken' => $accessToken->getToken(),
                    'refreshToken' => $accessToken->getRefreshToken(),
                    'expires' => $accessToken->getExpires(),
                    'baseDomain' => $baseDomain,
                ]
            );
        }
    );


$leadsService = $apiClient->leads();
$contactsService = $apiClient->contacts();
$companiesService = $apiClient->companies();
$customFieldsService = $apiClient->customFields(EntityTypesInterface::CONTACTS);





$customFieldName = 'Поле Список';
$isCustomFieldName = false;
$result = json_decode($customFieldsService->get(), true);

foreach ($result as $i){
    if ($i["name"] === $customFieldName){
        $isCustomFieldName = true;
    }
}

if (!$isCustomFieldName){
    $customFieldsCollection = new CustomFieldsCollection();
    $customFields = new SelectCustomFieldModel();
    $customFields->setName($customFieldName)
        ->setSort(30)
        ->setEnums((new CustomFieldEnumsCollection())
                ->add((new EnumModel())->setValue('1')->setSort(10))
                ->add((new EnumModel())->setValue('2')->setSort(20))
                ->add((new EnumModel())->setValue('3')->setSort(30)));
}




for($i = 0;$i != 1;$i++){
    $leadsCollection = new LeadsCollection();
    $companiesCollection = new CompaniesCollection();
    $linksCollection = new LinksCollection();
    $linksCollection = new LinksCollection();
    $contactsCollection = new ContactsCollection();

    $contact = new ContactModel();
    $lead = new LeadModel();
    $company = new CompanyModel();

    $contact->setName('Zxc' . $i);
    $lead->setName('Qwe' . $i);
    $company->setName('Asd' . $i);

    $companiesCollection->add($company);
    $leadsCollection->add($lead);
    $contactsCollection->add($contact);
    
    $contactCustomFieldsValues = new CustomFieldsValuesCollection();
    $multiselectCustomFieldValuesModel = new MultiselectCustomFieldValuesModel();

    $multiselectCustomFieldValuesModel->setFieldId(488133);
    $multiselectCustomFieldValuesModel->setValues((new MultiselectCustomFieldValueCollection())
                                        ->add((new MultiselectCustomFieldValueModel())->setValue("2")));
    $contactCustomFieldsValues->add($multiselectCustomFieldValuesModel);

    $contact->setCustomFieldsValues($contactCustomFieldsValues);
        


    $companiesCollection = $companiesService->add($companiesCollection);
    $leadsCollection = $leadsService->add($leadsCollection);
    $contactsCollection = $contactsService->add($contactsCollection);
    
    $linksCollection->add((new ContactModel())->setId($contact->getId()))
                    ->add((new CompanyModel())->setId($company->getId()));

    $linksCollection = $leadsService->link((new LeadModel())->setId($lead->getId()), $linksCollection);
}





echo ('<pre>');
printValue(json_decode($leadsService->get(), true));
printValue(json_decode($contactsService->get(), true));
printValue(json_decode($companiesService->get(), true));



function printValue($collection)
{
    foreach ($collection as $model)
    {
        foreach($model as $value)
        {
            echo($value . '<br>');
        }
    }
}
 
function saveToken($accessToken)
{
    if (
        isset($accessToken)
        && isset($accessToken['accessToken'])
        && isset($accessToken['refreshToken'])
        && isset($accessToken['expires'])
        && isset($accessToken['baseDomain'])
    ) {
        $data = [
            'accessToken' => $accessToken['accessToken'],
            'expires' => $accessToken['expires'],
            'refreshToken' => $accessToken['refreshToken'],
            'baseDomain' => $accessToken['baseDomain'],
        ];

        file_put_contents(TOKEN_FILE, json_encode($data));
    } else {
        exit('Invalid access token ' . var_export($accessToken, true));
    }
}

function getToken()
{
    $accessToken = json_decode(file_get_contents(TOKEN_FILE), true);

    if (
        isset($accessToken)
        && isset($accessToken['accessToken'])
        && isset($accessToken['refreshToken'])
        && isset($accessToken['expires'])
        && isset($accessToken['baseDomain'])
    ) {
        return new \League\OAuth2\Client\Token\AccessToken([
            'access_token' => $accessToken['accessToken'],
            'refresh_token' => $accessToken['refreshToken'],
            'expires' => $accessToken['expires'],
            'baseDomain' => $accessToken['baseDomain'],
        ]);
    } else {
        exit('Invalid access token ' . var_export($accessToken, true));
    }
}
