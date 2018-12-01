# Relation Parser

Парсер отношений для Eloquent моделей

## О пакете

Пакет создан исключительно в показательных целях. Язык использован русский умышленно. Автор не рекомендует использовать 
данный пакет в проде.


## Вступление

Relation Parser предоставляет вам удобный способ для получения информации по отношениям в ваших Eloquent моделях.

Вы можете использовать это для решения конфликтов при сохранении нескольких взаимозависимых сущностей.

### Установка

Для установки используйте

```
composer require omgitslock/relation-parser
```

### Пример использования

Предположим мы имеем модель Post

```
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
```
Тогда где-то в нашем приложении мы можем использовать

```
use Omgitslock\RelationParser\Parser;

$parser = new Parser();

$relationBag = $parser->parse(new Post); //instanceof Omgitslock\RelationParser\Entities\RelationBag

$relationBag->getRelationNamesList(); //return ['user', 'comments'];
```

Также RelationBag содержит в себе массив Relation, которые содержат метаинформацию по каждому отношению

```
$relations = $relationBag->getRelations();

//получим имя и вид каждого отношения
foreach($relations as $relation){
    echo 'Метод ' . $relation->getMethod(). ', тип ' . $relation->getType() . PHP_EOL;
}
```
Тогда результатом будет что-то подобное

``` 
Метод user, тип HasMany
Метод comments, тип BelongsTo
```
