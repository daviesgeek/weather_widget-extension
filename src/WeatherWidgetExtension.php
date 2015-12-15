<?php namespace Daviesgeek\WeatherWidgetExtension;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\DashboardModule\Widget\Extension\WidgetExtension;
use Anomaly\DashboardModule\Widget\Contract\WidgetInterface;
use Daviesgeek\WeatherWidgetExtension\Command\LoadContent;

class WeatherWidgetExtension extends WidgetExtension
{

  /**
   * This extension provides...
   *
   * This should contain the dot namespace
   * of the addon this extension is for followed
   * by the purpose.variation of the extension.
   *
   * For example anomaly.module.store::gateway.stripe
   *
   * @var null|string
   */
  protected $provides = 'anomaly.module.dashboard::widget.weather_widget';

  protected function load(WidgetInterface $widget) {
  }

  protected function content(WidgetInterface $widget) {
    $this->dispatch(new LoadContent($widget));
  }

}
