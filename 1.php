<?php
$leadsService = $apiClient->leads();
$contactsService = $apiClient->contacts();
$companiesService = $apiClient->companies();


for($i = 0;$i != 1000;$i++){
    $leadsCollection = new LeadsCollection();
    $companiesCollection = new CompaniesCollection();
    $linksCollection = new LinksCollection();

    $contact = new ContactModel();
    $lead = new LeadModel();
    $company = new CompanyModel();

    $contact->setName('Zxc' . $i);
    $lead->setName('Qwe' . $i);
    $company->setName('Asd' . $i);

    $companiesCollection->add($company);
    $leadsCollection->add($lead);

    $companiesCollection = $companiesService->add($companiesCollection);
    $leadsCollection = $leadsService->add($leadsCollection);
    $contactModel = $contactsService->addOne($contact);

    $linksCollection->add((new ContactModel())->setId($contact->getId()))
                    ->add((new CompanyModel())->setId($company->getId()));

    $linksCollection = $leadsService->link((new LeadModel())->setId($lead->getId()), $linksCollection);
}