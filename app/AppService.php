<?php

namespace App;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use App\FeedbackModel;

class AppService
{
  private function getServerUrl() {
    $ml_host = config('app.ml_host');
    $ml_port = config('app.ml_port');
    return $ml_host . ':' . $ml_port . '/';
  }

  private function getRestUrl($extension_name) {
    return $this->getServerUrl() . 'v1/resources/' . $extension_name;
  }

  private function getAuth() {
    $ml_username = config('app.ml_username');
    $ml_password = config('app.ml_password');
    return [ $ml_username, $ml_password, 'digest' ];
  }

  private function handleException(RequestException $e) {
    // properly handle error here
    echo $e->getResponse()->getBody();
  }

  public function submitFeedback(FeedbackModel $model) {
    try {
      $client = new Client();
      $response = $client->put($this->getRestUrl('feedback'), [
        'auth' => $this->getAuth(),
        'json' => $model->getAttributes()
      ]);

      return $response->getStatusCode() == 201;
    }
    catch(RequestException $e) {
      $this->handleException($e);
    }
  }
}
