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

  public function getExpenseTypes() {
    try {
      $client = new Client();
      $response = $client->get($this->getRestUrl('expenseTypes'), [
        'auth' => $this->getAuth()
      ]);

      $jsonDoc = json_decode($response->getBody(), true);
      return $jsonDoc["expenseTypes"];
    }
    catch(RequestException $e) {
      $this->handleException($e);
    }
  }

  public function addExpense(ExpenseModel $model) {
    try {
      $client = new Client();
      $response = $client->put($this->getRestUrl('expense'), [
        'auth' => $this->getAuth(),
        'json' => $model->getAttributes()
      ]);

      $jsonResponse = json_decode($response->getBody(), true);
      return $jsonResponse["expenseId"];
    }
    catch(RequestException $e) {
      $this->handleException($e);
    }
  }

  public function addExpenseReceipt($expenseId, $file) {
    try {
      $filename = time() . '.' . $file->extension();
      $uri = '/expense/' . $expenseId . '/' . $filename;

      $client = new Client();
      $response = $client->put($this->getServerUrl() . 'v1/documents', [
        'auth' => $this->getAuth(),
        'query' => [
          'uri' => $uri,
          'collection' => 'expenseReceipt'
        ],
        'headers' => [
          'Content-type' => $file->getMimeType()
        ],
        'body' => fopen($file->path(), 'r')
      ]);

      return $response->getStatusCode() == 201;
    }
    catch(RequestException $e) {
      $this->handleException($e);
    }
  }

  public function searchExpenses($qtext) {
    try {
      $client = new Client();
      $response = $client->get($this->getRestUrl('expense'), [
        'auth' => $this->getAuth(),
        'query' => [
          'rs:qtext' => $qtext
        ]
      ]);

      $jsonResponse = json_decode($response->getBody(), true);
      $jsonResponse['results'] = $jsonResponse['results'] == null ? [] : $jsonResponse['results'];
      return $jsonResponse;
    }
    catch(RequestException $e) {
      $this->handleException($e);
    }
  }

  public function approveExpense($expenseId) {
    try {
      $client = new Client();
      $response = $client->put($this->getRestUrl('expenseApprove'), [
        'auth' => $this->getAuth(),
        'query' => [
          'rs:expenseId' => $expenseId
        ]
      ]);

      return $response->getStatusCode() == 204;
    }
    catch(RequestException $e) {
      $this->handleException($e);
    }
  }

  public function rejectExpense($expenseId) {
    try {
      $client = new Client();
      $response = $client->put($this->getRestUrl('expenseReject'), [
        'auth' => $this->getAuth(),
        'query' => [
          'rs:expenseId' => $expenseId
        ]
      ]);

      return $response->getStatusCode() == 204;
    }
    catch(RequestException $e) {
      $this->handleException($e);
    }
  }

  public function getExpenseReceipt($expenseId) {
    try {
      $client = new Client();
      $response = $client->get($this->getRestUrl('expenseReceipt'), [
        'auth' => $this->getAuth(),
        'query' => [
          'rs:expenseId' => $expenseId
        ]
      ]);

      return [
        'content-type' => $response->getHeader('Content-Type'),
        'content' => $response->getBody()
      ];
    }
    catch(RequestException $e) {
      $this->handleException($e);
    }
  }
}
