Тестовое задание
=
Инструкция по развёртыванию
-
1. git clone git@github.com:zergbz1988/tan-test.git в любую папку (tan-test)
2. Установить docker, если не установлен. Установить можно по ссылке https://docs.docker.com/install/
3. Перейти в папку проекта (напр. tan-test), скопировать файлы `src/app/config/doctrine/db.example.php` в `src/app/config/doctrine/db.php`, `src/app/config/doctrine/mongodb.example.php` в `src/app/config/doctrine/mongodb.php`
4. Перейти в папку проекта (напр. tan-test), выполнить команду в терминале (для linux) или в powershell (для windows):
 `docker-compose up -d`
5. После запуска контейнеров выполнить команду: `docker exec -it png-webserver bash`
6. В запустившейся командной строке контейнера выполнить команды `composer install` и `./migrations migrate`

**Done!**

Инструкция по использованию
-
1. Запрос отправлять по адресу `localhost/Car/Info`, метод `POST`, заголовок `content-type` должен соответствовать настройке приложения (`application/json` для `JsonRequest`, `text/plain` для `SerializedObjectRequest`, `application/xml` для `XmlRequest`, `application/x-yaml` для `YamlRequest`). 
2. Настройки приложения меняются в файле `src/app/config/app.php`. 
Все возможные настройки уже указаны (не активные закомментированы) - менять можно `requestClass`, `responseClass` и `store[type]` - тип принимаемых данных (`json`, `xml`, `yaml`, `serialized object`), тип возвращаемых данных (`json`, `xml`, `html`) и тип хранилища (`sql`, `mongodb`) соответственно. 
Так же можно отключить генерацию фикстур (`store[useFixtures]`).

**Пример отправляемых данных**

`json`: `{"make":"Mercedes","model":"C","componentry":"Эле","name":"Василий","address":"Москва","phone":9010923345}`
`yaml`: 
```
make: Mercedes
model: C
componentry: Эле
name: Василий
address: Москва
phone: 9010923345
```         
`serialized object`: `a:6:{s:4:"make";s:8:"Mercedes";s:5:"model";s:1:"C";s:11:"componentry";s:6:"Эле";s:4:"name";s:14:"Василий";s:7:"address";s:12:"Москва";s:5:"phone";i:9010923345;}`
`xml`: 
```
<Root>
    <make>Mercedes</make>
    <model>C</model>
    <componentry>Эле</componentry>
    <name>Василий</name>
    <address>Москва</address>
    <phone>9010923345</phone>
</Root>
```

**Пример ответа**

`json`: `{"status":"ok","data":{"car":{"price":2500000,"vin":"4USBT53544LT26841"},"dealer":{"name":"Дилерский центр №1","address":"ул. Академика Янгеля, 5"}}}`
`xml`: 
```
<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Status>ok</Status>
    <Data>
        <Car>
            <Price>2500000</Price>
            <Vin>4USBT53544LT26841</Vin>
        </Car>
        <Dealer>
            <Name>Дилерский центр №1</Name>
            <Address>ул. Академика Янгеля, 5</Address>
        </Dealer>
    </Data>
</Response>
```
`html`:
```
<html>
    <head></head>
    <body>
        <dl>
            <dt>status</dt>
            <dd>ok</dd>
            <dt>data</dt>
            <dd>
                <dl>
                    <dt>car</dt>
                    <dd>
                        <dl>
                            <dt>price</dt>
                            <dd>2500000</dd>
                            <dt>vin</dt>
                            <dd>4USBT53544LT26841</dd>
                        </dl>
                    </dd>
                    <dt>dealer</dt>
                    <dd>
                        <dl>
                            <dt>name</dt>
                            <dd>Дилерский центр №1</dd>
                            <dt>address</dt>
                            <dd>ул. Академика Янгеля, 5</dd>
                        </dl>
                    </dd>
                </dl>
            </dd>
        </dl>
    </body>
</html>
```

*P.S. Был выбран способ менять тип входных/выходных данных через фйл конфигурации. Как альтернативные способы можно было бы определять тип входных данных динамически по заголовку запроса `content-type` и пытаться парсить запрос в соответствии с предполагаемым типом, а тип ответа динамически менять исходя из значения заголовка запроса `accept`. Еще вариант - по роуту в роутере: в зависимости от окончания адреса (`.json, .xml, .html`) - понимать, какой тип данных нужно возвращать. В последнем случае можно синхронизировать типы получаемых и возвращаемых данных (т.к. оба будут определяться через роут).*