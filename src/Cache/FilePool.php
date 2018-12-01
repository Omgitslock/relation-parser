<?php
namespace Omgitslock\RelationParser\Cache;

use SplFileObject;

/**
 * Реeстр хранит ключ -> значение,
 * где ключ - это строка(название файла),
 * значение - экземпляр SPlFileObject
 *
 * Пару слов:
 * этот реестр задумывался как кэширование файлов, с которыми мы уже работали.
 * На деле же имеем: при тестах на ~20 уникальных файлов.
 * При прогоне 100000 раз,
 * т.е. мы либо пытаемся найти среди имеющихся в FilePool в первом случае,
 * либо создаём новый объект во втором
 * результаты выглядят примерно так:
 *  1 - с пулом
 *  Memory usage 0.203568 megabytes
 *  Time usage 0.13007807731628 microseconds
 *
 *  2 - без него
 *  Memory usage 0.00128 megabytes
 *  Time usage 0.5860698223114 microseconds
 *
 * Итог - экономия на спичках
 *
 *
 * Class FilePool
 */
class FilePool
{
    /**
     *
     * @var array
     */
    protected static $files = [];

    /**
     * @param $filePath
     *
     * @return null|SplFileObject
     */
    public function getOrCreate($filePath): ?SplFileObject
    {
        if(!isset(self::$files[$filePath])){
            try {
                self::$files[$filePath] = new SplFileObject($filePath);
            }catch(\Throwable $e){
                return null;
            }
        }

        return self::$files[$filePath] ?? null;
    }

    /**
     * @param $filePath
     *
     * @return mixed|null
     */
    public function get($filePath)
    {
        return self::$files[$filePath] ?? null;
    }

    /**
     * @param $filePath
     * @param SplFileObject $file
     *
     * @return $this
     */
    public function add(SplFileObject $file): self
    {
        $filePath = $file->getPathname();
        
        self::$files[$filePath] = $file;

        return $this;
    }

    /**
     * @param $filePath
     *
     * @return bool
     */
    public function exist($filePath) : bool
    {
        return isset(self::$files[$filePath]);
    }

    /**
     * @param $filePath
     *
     * @return FilePool
     */
    public function remove($filePath) : self
    {
        unset(self::$files[$filePath]);

        return $this;
    }

    /**
     * Проверяем пулл на пустоту
     *
     * @return bool
     */
    public function isEmpty()
    {
        if(self::$files){
            return false;
        }

        return true;
    }

}