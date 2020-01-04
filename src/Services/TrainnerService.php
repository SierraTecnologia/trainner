<?php
/**
 * Serviço referente a linha no banco de dados
 */

namespace Trainner\Services;

/**
 * 
 */
class TrainnerService
{

    protected $config;

    protected $modelServices = false;

    public function __construct($config = false)
    {
        if (!$this->config = $config) {
            $this->config = config('sitec.sitec.models');
        }
    }

    public function getModelServicesToArray()
    {

        $models = $this->getModelServices(); 
        $array = [];

        foreach ($models as $model) {
            $array[] = [
                'model' => $model,
                'url' => $model->getUrl(),
                'count' => $model->getRepository()->count(),
                'icon' => \Support\Template\Layout\Icons::getForNameAndCache($model->getName()),
                'name' => $model->getName(),
            ];
        }
        return collect($array);
    }

    public function getModelServices()
    {
        if (!$this->modelServices) {
            $this->modelServices = collect($this->config)->map(function ($value) {
                return new ModelService($value);
            });
        }

        return $this->modelServices;
    }

    public function modelIsValid($model)
    {
        $services = $this->getModelServices();

        if (!is_array($services)) {
            return false;
        }

        foreach ($services as $service) {
            if ($service->isModelClass($model)) {
                return true;
            }
        }
        
        return false;
    }

}
