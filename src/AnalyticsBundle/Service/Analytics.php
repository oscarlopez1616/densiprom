<?php

namespace AnalyticsBundle\Service;

class Analytics {

    private $_service_account_email;
    private $_key_file_location;
    private $_client;
    private $_analytics;
    private $_profileId;

    function __construct() {
        $this->_service_account_email = "densiprom@storied-destiny-134923.iam.gserviceaccount.com";
        $this->_key_file_location = dirname(__FILE__) . "/../Resources/secrets/My Project-ab84f3e42b8b.json";
        $this->_analytics = $this->getService();
        $this->_profileId = $this->getProfileById($this->_analytics, 'UA-15758073-6');
    }

    function getInformeAnalyticsInfoForDealEngineV1Batch($PartialPagePathArr, $startDate = "yesterday", $endDate = "yesterday", $timeSleepAnalyticsCuota = 1100000) {
        $threshold=10;//las peticiones se hacen de 10 en 10 maximo
        $this->_client->setUseBatch(true);
        $batch = new \Google_Http_Batch($this->_client);
        $thresholdIndex = 1;
        $temp_array = array();
        $results = array();
        $metrics = 'ga:users,ga:newUsers,ga:bounces,ga:bounceRate,ga:uniquePageviews';
        foreach ($PartialPagePathArr as $key => $value) {
            $optParams = array('dimensions' => 'ga:sourceMedium', 'filters' => 'ga:pagePath' .$value);  
            $batchUnit = $this->_analytics->data_ga->get('ga:' . $this->_profileId, $startDate, $endDate, $metrics, $optParams);
            $batch->add($batchUnit, $value);
            if ($thresholdIndex % $threshold == 0) {
                $temp_array = $batch->execute();
                $batch = new \Google_Http_Batch($this->_client);              
                $temp_array = $this->toArrayResultsBatch($temp_array);
                if(count($temp_array)>0) $results = array_merge($results, $temp_array);   
                $temp_array = array();
                usleep($timeSleepAnalyticsCuota);
            }
            $thresholdIndex++;
        }
        $temp_array = $batch->execute();
        $temp_array = $this->toArrayResultsBatch($temp_array);
        if(count($temp_array)>0) $results = array_merge($results, $temp_array);
        return $results;
    }

    function getResults($startDate, $endDate, $metrics, $optParams = array()) {
        return $this->_analytics->data_ga->get('ga:' . $this->_profileId, $startDate, $endDate, $metrics, $optParams);
    }

    /**
     * 
     * @param array $results
     * @return arrary()
     */
    function toArrayResultsBatch($results) {
        $arrayResult = array();
        if (count($results) > 0) {
            foreach ($results as $responseIndex => $value) {
                if (getType($value) == "object" &&  get_class($value)!="Google_Service_Exception") {
                    $totalResults = $value["totalResults"];
                    $profileName = $value["profileInfo"]["profileName"];
                    $arrayResult[$responseIndex]["profileName"] = $profileName;
                    $rows = $value["rows"];
                    $ColumnHeaders = $value["columnHeaders"];
                    $i = 0;
                    foreach ($ColumnHeaders as $keyColumnHeader => $ColumnHeader) {
                        if ($totalResults > 0) {
                            foreach ($rows as $key => $value) {
                                $arrayResult[$responseIndex][$ColumnHeaders[$i]["name"]][$key] = $rows[$key][$i];
                            }
                        } else {
                            $arrayResult[$responseIndex][$ColumnHeaders[$i]["name"]][0] = null;
                        }
                        $i++;
                    }
                }else if(get_class($value)=="Google_Service_Exception"){
                    echo $value->getMessage();
                    $errorGoogle =json_decode($value->getMessage());
                    exit($errorGoogle->error->errors[0]->reason); 
                }
            }
        }
        return $arrayResult;
    }

    function getService() {

        // Create and configure a new client object.
        $this->_client = new \Google_Client();
        $this->_client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $this->_client->setApplicationName("DensiProm");
        $analytics = new \Google_Service_Analytics($this->_client);
        
        //Auth Cliente
        putenv('GOOGLE_APPLICATION_CREDENTIALS='. $this->_key_file_location);
        $this->_client->useApplicationDefaultCredentials();
        return $analytics;
    }

    private function getRowId($items, $id) {
        foreach ($items as $key => $value) {
            if ($value["id"] == $id)
                return $value;
        }
        throw new \Exception('Propiedad no Encontrada');
    }

    function getProfileById($analytics, $id) {
        // Get the user's first view (profile) ID.
        // Get the list of accounts for the authorized user.
        $accounts = $analytics->management_accounts->listManagementAccounts();
        //print_r($accounts->getItems());
        if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            $firstAccountId = $items[0]->getId();

            // Get the list of properties for the authorized user.
            $properties = $analytics->management_webproperties->listManagementWebproperties($firstAccountId);

            if (count($properties->getItems()) > 0) {
                $items = $properties->getItems();
                //print_r($properties->getItems());
                $firstPropertyId = $this->getRowId($items, $id)->getId();

                // Get the list of views (profiles) for the authorized user.
                $profiles = $analytics->management_profiles
                        ->listManagementProfiles($firstAccountId, $firstPropertyId);

                if (count($profiles->getItems()) > 0) {
                    $items = $profiles->getItems();

                    // Return the first view (profile) ID.
                    return $items[0]->getId();
                } else {
                    throw new \Exception('No views (profiles) found for this user.');
                }
            } else {
                throw new \Exception('No properties found for this user.');
            }
        } else {
            throw new \Exception('No accounts found for this user.');
        }
    }

}
