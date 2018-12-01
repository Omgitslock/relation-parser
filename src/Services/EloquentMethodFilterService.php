<?php

namespace Omgitslock\RelationParser\Services;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Omgitslock\RelationParser\Contracts\FilterInterface;

class EloquentMethodFilterService implements FilterInterface
{

    /**
     * Методы, которые содержатся в родительской модели
     *
     * @var array
     */
    protected static $parentMethods;

    /**
     * Родительская модель(её методы мы будем игнорировать)
     *
     * @var string
     */
    protected $parentModel = '\Illuminate\Database\Eloquent\Model';


    public function __construct()
    {
        $this->setParentMethods();
    }

    /**
     * Сеттер для parentMethods
     * Нам необходим только список названий, поэтому мы можем использовать get_class_methods
     * Переменная $parentMethods статическая, только для оптимизации
     *
     * @return EloquentMethodFilterService
     */
    protected function setParentMethods(): EloquentMethodFilterService
    {
        if (!self::$parentMethods) {
            self::$parentMethods = get_class_methods($this->parentModel);
        }

        return $this;
    }


    /**
     * Удаляем из массива пришедших методов
     * "сервисные" Eloquent методы
     *
     * @param array $methods
     *
     * @return array
     */
    protected function ignoreServiceMethods(array $methods): array
    {
        $result = [];

        foreach ($methods as $method) {
            if ($this->isServiceMethod($method)) {
                continue;
            }
            $result[] = $method;
        }

        return $result;
    }

    /**
     * Удаляем из массива пришедших методов
     * стандартные Eloquent методы
     *
     * @param array $methods
     *
     * @return array
     */
    protected function ignoreParentMethods(array $methods): ?array
    {
        $methods = array_diff($methods, self::$parentMethods);

        return $methods;
    }

    /**
     * {@inheritDoc}
     */
    public function filter(array $methods): ?array
    {
        $methods = $this->ignoreParentMethods($methods);
        $methods = $this->ignoreServiceMethods($methods);

        return $methods;
    }

    /**
     * Является ли метод "служебным",
     * то есть аксессером, или скоупом etc.
     *
     * @param string $method
     *
     * @return bool
     */
    public function isServiceMethod(string $method): bool
    {
        if ($this->isAccessor($method) || $this->isMutator($method) || $this->isScope($method)) {
            return true;
        }

        return false;
    }


    /**
     * Проверяем является ли метод аксессером
     *
     * @param string $method
     *
     * @return bool
     */
    public function isAccessor(string $method): bool
    {
        if (Str::startsWith($method, 'get') && Str::endsWith($method, 'Attribute')) {
            return true;
        }

        return false;
    }

    /**
     * Является ли метод мутатором
     *
     * @param string $method
     *
     * @return bool
     */
    public function isMutator(string $method): bool
    {
        if (Str::startsWith($method, 'set') && Str::endsWith($method, 'Attribute')) {
            return true;
        }

        return false;
    }

    /**
     * Является ли метод скоупом
     *
     * @param string $method
     *
     * @return bool
     */
    public function isScope(string $method): bool
    {
        if (Str::startsWith($method, 'scope')) {
            return true;
        }

        return false;
    }


    /**
     * Устанавливаем родительскую модель
     * Мы можем создать свою(базовую) Eloquent модель, и наследовать от неё другие модели приложения
     * в таком случае можно переопределить дефолтную parent модель и работать уже с кастомной
     *
     * @param Model $parentModel
     *
     * @return EloquentMethodFilterService
     */
    public function setParentModel(Model $parentModel): EloquentMethodFilterService
    {
        $this->parentModel = get_class($parentModel);

        $this->setParentMethods();

        return $this;
    }


    /**
     * Возвращаем родительскую модель
     *
     * @return string
     */
    public function getParentModel(): string
    {
        return $this->parentModel;
    }

}