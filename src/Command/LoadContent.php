<?php namespace Daviesgeek\WeatherWidgetExtension\Command;

use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\DashboardModule\Widget\Contract\WidgetInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Cache\Repository;
use GuzzleHttp\Client;

class LoadContent implements SelfHandling {

  /**
   * The widget instance.
   *
   * @var WidgetInterface
   */
  protected $widget;

  /**
   * Create a new LoadContent instance.
   *
   * @param WidgetInterface $widget
   */
  public function __construct(WidgetInterface $widget)
  {
      $this->widget = $widget;
  }

  /**
   * Handles getting and loading the content
   */
  public function handle(ConfigurationRepositoryInterface $configuration) {

    // First get the location and split it into city & state
    list($city, $state) = explode(',', $configuration->value('daviesgeek.extension.weather_widget::location', $this->widget->getId()));

    // Trim both and slug-ify the city
    $state = trim($state);
    $request_city = str_replace(" ", "_", trim($city));

    // Retrieve the API key
    $key = $configuration->value('daviesgeek.extension.weather_widget::api_key', $this->widget->getId());

    // Build the URL
    $url = 'http://api.wunderground.com/api/' . $key . '/conditions/q/' . $state. '/' . $request_city . '.json';

    // Create a new \GuzzleHttp\Client
    $client = new Client();

    // Make the request
    $res = $client->request('GET', $url);

    // Set the content to the twig template with the decoded JSON as the data
    $this->widget->setContent(view('daviesgeek.extension.weather_widget::template', json_decode($res->getBody(), true)));
  }

}