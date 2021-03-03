
<a name="87a425cd-f608-462d-9064-abf5b6b79aa1"></a>

Вы получили от нас параметры доступа. Самое время подключить ваш аккаунт к новому каналу.

Для этого нам потребуется:

*   Идентификатор аккаунта amoCRM для сервиса online чатов. Как его получить подробно описано ниже
*   Идентификатор канала и секрет, который вы получили в ответном письме от технической поддержки amoCRM

Формируем POST запрос, в котором указываем идентификатор аккаунта для подключения к нашему каналу.

Подписываем запрос с помощью секрета и добавляем подпись в заголовок X-Signature
#### Пример запроса


```javascript
POST https://amojo.amocrm.ru/v2/origin/custom/f90ba33d-c9d9-44da-b76c-c349b0ecbe41/connect
Date: Mon, 03 Oct 2020 15:11:21 +0000
Content-Type: application/json
Content-MD5: a5e8ae04332a6d0aac15f01ad05d40e3
X-Signature: 85d94e7f21bdd3971c2721ca22793e45a96d0c75
```
            
#### Ответ


```javascript
{
  &quot;account_id&quot;: &quot;af9945ff-1490-4cad-807d-945c15d88bec&quot;,
  &quot;scope_id&quot;: &quot;f90ba33d-c9d9-44da-b76c-c349b0ecbe41_af9945ff-1490-4cad-807d-945c15d88bec&quot;,
  &quot;title&quot;: &quot;ChatIntegration&quot;,
  &quot;hook_api_version&quot;: &quot;v2&quot;
}
```

#### Отправка сообщения

Вы можете отправлять сообщения следующих типов: текст, изображение, файл, локация, контакт.

Очень подробно формат данных запроса описана в разделе API [Отправка сообщения](https://www.amocrm.ru/developers/content/chats/chat-api-reference#chat-message)

Для отправки сообщения нам понадобится:

*   Scope id, который мы получили при подключении аккаунта к каналу
*   Секрет канала для формирования подписи

Рассмотрим несколько примеров:
#### Пример запроса


```javascript
POST https://amojo.amocrm.ru/v2/origin/custom/f90ba33d-c9d9-44da-b76c-c349b0ecbe41_af9945ff-1490-4cad-807d-945c15d88bec
Date: Mon, 03 Oct 2020 16:06:48 +0000
Content-Type: application/json
Content-MD5: 204dc99bcaa899db72954f16de987022
X-Signature: 6201ab8b5154bfa2af847920f1dfeab74b125489

{
  &quot;account_id&quot;: &quot;af9945ff-1490-4cad-807d-945c15d88bec&quot;,
  &quot;event_type&quot;: &quot;new_message&quot;,
  &quot;payload&quot;: {
    &quot;timestamp&quot;: 1596470808,
    &quot;msgid&quot;: &quot;5f283618af2c8&quot;,
    &quot;conversation_id&quot;: &quot;skc-8e3e7640-49af-4448-a2c6-d5a421f7f217&quot;,
    &quot;sender&quot;: {
      &quot;id&quot;: &quot;sk-1376265f-86df-4c49-a0c3-a4816df41af9&quot;,
      &quot;avatar&quot;: &quot;https:/example.com/users/avatar.png&quot;,
      &quot;name&quot;: &quot;Example Client&quot;,
      &quot;profile&quot;: {
          &quot;phone&quot;: &quot;79151112233&quot;,
          &quot;email&quot;: &quot;example.client@example.com&quot;
      },
      &quot;profile_link&quot;: &quot;https://example.com/profile/example.client&quot;
    },
    &quot;message&quot;: {
      &quot;type&quot;: &quot;text&quot;,
      &quot;text&quot;: &quot;Приветствую, хотел бы уточнить пару вопросов по артикулу A13435&quot;
    },
    &quot;silent&quot;: true
  }
}
```
            
#### Ответ


```javascript
{&quot;new_message&quot;:{&quot;msgid&quot;:&quot;1bf6a765-ec6f-4680-8cd5-6f2d31f78ebc&quot;}}
```
<a name="fc705c2b-0428-403d-a9c7-e9f6b730b7a4"></a>

В интерфейс amoCRM моментально приходит новый запрос (карточка неразобранного)

Центр нотификаций

![](https://www.amocrm.ru/static/assets/developers/files/chats/cn.png)

Интерфейс воронки

![](https://www.amocrm.ru/static/assets/developers/files/chats/lead_list.png)

Карточка неразобранного

![](https://www.amocrm.ru/static/assets/developers/files/chats/unsorted_card.png)

Любой сотрудник, имеющий доступ к карточке неразобранного, может посмотреть переписку и ответить клиенту.

Ответ клиенту

![](https://www.amocrm.ru/static/assets/developers/files/chats/unsorted_repl_form.png)

Теперь чат выглядит так

![](https://www.amocrm.ru/static/assets/developers/files/chats/unsorted_chat.png)

Получение ответа на URL обратного вызова

Как только пользователь amoCRM ответил клиенту, на URL обратного вызова должен прийти POST запрос с данными сообщения.

![](https://www.amocrm.ru/static/assets/developers/files/chats/webhook_example.png)
#### Пример запроса
Webhook в формате JSON

```javascript
{
  &quot;receiver&quot; : &quot;U1&quot; ,
  &quot;conversation_id&quot; : &quot;c59678affa1db6&quot; ,
  &quot;type&quot; : &quot;text&quot; ,
  &quot;text&quot; : &quot;Привет,  Джон! Для Вас - Бесплатно! Но... есть нюансы.&quot; ,
  &quot;media&quot; : &quot;&quot; ,
  &quot;thumbnail&quot; : &quot;&quot; ,
  &quot;file_name&quot; : &quot;&quot; ,
  &quot;file_size&quot; : 0
}
```

<a name="d40f160e-0cd7-426d-8aa9-3cce3353c11b"></a>

### Разработка виджета

Вы можете предоставить другим пользователям amoCRM возможность подлючить ваш канал к своему аккаунту. Для этого необходимо разработать виджет, с помощью которого пользователь сможет связать свой аккаунт с вашим каналом.

Подробнее о разработке виджета вы можете прочитать в [документации по виджетам](https://www.amocrm.ru/developers/content/integrations/intro)

#### Дополнительные требования к виджету

В manifest.json, в объект locations добавить параметр “lead_sources”. После чего ваш виджет отобразится в разделе настройки чатов

![](https://www.amocrm.ru/static/assets/developers/files/chats/lead_sources_big.png)

1.  Пользователь активирует окно подключения виджета
2.  Вводит логин / пароль от учетной записи вашего сервиса
3.  Отправляет на ваш сервер связку логин/пароль и id своего аккаунта. id аккаунта может быть получен виджетом автоматически через следующий JS скрипт: AMOCRM.constant(‘account’).amojo_id
4.  Ваш сервер валидирует учетные данные и вызывает запрос на подключение нового аккаунта к каналу чатов.

#### Пример виджета

[Скачать](https://www.amocrm.ru/static/assets/developers/demo_chat.zip)

### <a id="chats-cap-write-first">Написать первым</a>

Интерфейс amoCRM позволяет инициировать переписку с клиентом из карточки. Для этого достаточно создать карточку и добавить в нее контакт с номером телефона.

Если ваш канал поддерживает функцию “написать первым”, то он отобразится в выпадающем списке Click-To-Call (см. [Регистрация нового канала](/developers/content/chats/chat-capabilities#chats-cap-channel-register))

![](https://www.amocrm.ru/static/assets/developers/files/chats/write-first-1.png)

Пользователь выбирает ваш виджет и отправляет сообщение.

![](https://www.amocrm.ru/static/assets/developers/files/chats/write-first-3.png)

На URL обратного вызова уйдет Webhook формата 2.0 (см. [Webhook 2.0](https://amocrm.ru/developers/content/chats/development#chats-dev-webhook-2-0)), в котором передаются идентификаторы чата, получателя и сообщения со стороны amoCRM).

Ваш сервер интеграции должен обработать запрос, и попытаться отправить сообщение получателю. По факту отправки или невозможности отправить сообщение, интеграция должна отправить запрос в amoCRM на изменение статуса сообщения. (см. [Статус доставки](https://amocrm.ru/developers/content/chats/development#chats-dev-delivery-status))

Когда клиент ответит на сообщение, в дополнение к стандартным параметрам запроса на отправку сообщения, нужно передать conversation_ref_id и sender.ref_id, полученные ранее из Webhook 2\. , чтобы amoCRM связала чат и получателя на своей стороне с вашими. (см. [Отправка сообщения](https://amocrm.ru/developers/content/chats/chat-api-reference#chat-message))

![](https://www.amocrm.ru/static/assets/developers/files/chats/write-fiirst-2.png)
<!-- Generated at Wed, 03 Mar 2021 08:35:08 +0000. amoCRM Documentation Generator -->