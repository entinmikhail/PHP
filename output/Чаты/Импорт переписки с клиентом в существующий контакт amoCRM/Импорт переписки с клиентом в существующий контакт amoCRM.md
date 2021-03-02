
Данный пример демонстрирует возможность импорта  в amoCRM существующей переписки на стороне интеграции между клиентом и менеджером.<br/>
С точки зрения бизнес логики клиент уже существующий, поэтому нам не нужно что бы создавалось неразобранное. <br/> Контакт для клиента создадим для наглядности процесса.



<a name=""></a>

### Подключаем канал к аккаунту

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

<a name=""></a>

### Создаем новый чат

#### Пример запроса


```javascript
POST https://amojo.amocrm.ru/v2/origin/custom/f90ba33d-c9d9-44da-b76c-c349b0ecbe41_af9945ff-1490-4cad-807d-945c15d88bec/chats
Date: Mon, 03 Oct 2020 15:17:55 +0000
Content-Type: application/json
Content-MD5: 28623103cc158fde408e6ecd1965d437
X-Signature: 7cc462e28eadbb842a2a49edb469f15f24c56676
```
            
#### Ответ


```javascript
{
    &quot;conversation_id&quot;: &quot;skc-8e3e7640-49af-4448-a2c6-d5a421f7f217&quot;,
    &quot;user&quot;: {
        &quot;id&quot;: &quot;sk-1376265f-86df-4c49-a0c3-a4816df41af9&quot;,
        &quot;avatar&quot;: &quot;https:/example.com/users/avatar.png&quot;,
        &quot;name&quot;: &quot;Example Client&quot;,
        &quot;profile&quot;: {
            &quot;phone&quot;: &quot;79151112233&quot;,
            &quot;email&quot;: &quot;example.client@example.com&quot;
        },
        &quot;profile_link&quot;: &quot;https://example.com/profile/example.client&quot;
    }
}
```

<a name=""></a>

### Создаем контакт

#### Пример запроса


```javascript
POST /api/v4/contacts HTTP/1.1
Host: https://onlinechat.amocrm.ru
Content-Type: application/json
Authorization: Bearer xxxx

[
    {
        &quot;first_name&quot;: &quot;Jack200803&quot;,
        &quot;last_name&quot;: &quot;Tester&quot;
    }

]
```
            
#### Ответ


```javascript
{
    &quot;_links&quot;: {
        &quot;self&quot;: {
            &quot;href&quot;: &quot;https://onlinechat.amocrm.ru/api/v4/contacts&quot;
        }
    },
    &quot;_embedded&quot;: {
        &quot;contacts&quot;: [
            {
                &quot;id&quot;: 3102959,
                &quot;request_id&quot;: &quot;0&quot;,
                &quot;_links&quot;: {
                    &quot;self&quot;: {
                        &quot;href&quot;: &quot;https://onlinechat.amocrm.ru/api/v4/contacts/3102959&quot;
                    }
                }
            }
        ]
    }
}
```

<a name=""></a>

### Привязка чата к контакту

#### Пример запроса


```javascript
POST /api/v4/contacts/chats HTTP/1.1
Host: https://onlinechat.amocrm.ru


[
	{
		&quot;contact_id&quot;: 3102959,
		&quot;chat_id&quot;:&quot;6cbab3d5-c4c1-46ff-b710-ad59ad10805f&quot;
	}

]
```
            
#### Ответ


```javascript
{
    &quot;_total_items&quot;: 1,
    &quot;_embedded&quot;: {
        &quot;chats&quot;: [
            {
                &quot;chat_id&quot;: &quot;6cbab3d5-c4c1-46ff-b710-ad59ad10805f&quot;,
                &quot;contact_id&quot;: 3102959,
                &quot;id&quot;: 26219,
                &quot;request_id&quot;: &quot;0&quot;
            }
        ]
    }
}
```

<a name=""></a>

### Проверим привязку чата к контакту


Этот шаг необязателен, только для демонстрации возможности получить привязку по чата к контактам. Подробнее можно ознакомится на [странице метода](https://amocrm.ru/developers/content/api/contacts#contacts-chat-list)
#### Пример запроса


```javascript
POST /api/v4/contacts/chats HTTP/1.1
Host: https://onlinechat.amocrm.ru


[
	{
		&quot;contact_id&quot;: 3102959,
		&quot;chat_id&quot;:&quot;6cbab3d5-c4c1-46ff-b710-ad59ad10805f&quot;
	}

]
```
            
#### Ответ


```javascript
{
    &quot;_total_items&quot;: 1,
    &quot;_embedded&quot;: {
        &quot;chats&quot;: [
            {
                &quot;chat_id&quot;: &quot;6cbab3d5-c4c1-46ff-b710-ad59ad10805f&quot;,
                &quot;contact_id&quot;: 3102959,
                &quot;id&quot;: 26219,
                &quot;request_id&quot;: &quot;0&quot;
            }
        ]
    }
}
```

<a name=""></a>

### Импорт сообщения от клиента

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
      &quot;text&quot;: &quot;Можно ли оплатить заказ при получении ?&quot;
    },
    &quot;silent&quot;: true
  }
}
```
            
#### Ответ


```javascript
{
  &quot;new_message&quot;: {
    &quot;msgid&quot;: &quot;1bf6a765-ec6f-4680-8cd5-6f2d31f78ebc&quot;
  }
}
```

<a name=""></a>

### Импорт сообщения от пользователя аккаунта

#### Пример запроса


```javascript
POST https://amojo.amocrm.ru/v2/origin/custom/f90ba33d-c9d9-44da-b76c-c349b0ecbe41_af9945ff-1490-4cad-807d-945c15d88bec
Date: Mon, 03 Oct 2020 16:09:12 +0000
Content-Type: application/json
Content-MD5: 671efccd7cedf63b72823faf9a8037ff
X-Signature: 61a129968e586e8a021c2dfcc6be08e896a4fd77

{
  &quot;account_id&quot;: &quot;af9945ff-1490-4cad-807d-945c15d88bec&quot;,
  &quot;event_type&quot;: &quot;new_message&quot;,
  &quot;payload&quot;: {
    &quot;timestamp&quot;: 1596470952,
    &quot;msgid&quot;: &quot;skm-5f2836a8ca468&quot;,
    &quot;conversation_id&quot;: &quot;skc-8e3e7640-49af-4448-a2c6-d5a421f7f217&quot;,
    &quot;sender&quot;: {
      &quot;id&quot;: &quot;sk-e1982bb8-bdf1-4fa5-841d-7d5cebd77f7b&quot;,
      &quot;ref_id&quot;: &quot;d8d9f9c4-9611-4794-a136-a253a13e1bb5&quot;,
      &quot;name&quot;: &quot;Менеджер Василий&quot;
    },
    &quot;receiver&quot;: {
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
      &quot;text&quot;: &quot;Да, конечно. Вы можете оплатить наличными и картой курьеру при получении.&quot;
    },
    &quot;silent&quot;: true
  }
}
```
            
#### Ответ


```javascript
{
  &quot;new_message&quot;: {
    &quot;msgid&quot;: &quot;3985523d-78b3-45b7-aeaf-142405bbf1dc&quot;
  }
}

```

<a name=""></a>

### Получаем историю сообщений по чату

#### Пример запроса


```javascript
GET https://amojo.amocrm.ru/v2/origin/custom/f90ba33d-c9d9-44da-b76c-c349b0ecbe41_af9945ff-1490-4cad-807d-945c15d88bec/chats/6cbab3d5-c4c1-46ff-b710-ad59ad10805f/history?limit=50&amp;offset=0
Date: Mon, 03 Oct 2020 16:23:14 +0000
Content-Type: application/json
Content-MD5: d41d8cd98f00b204e9800998ecf8427e
X-Signature: 5693447e362dcb3bc77abeb27888ff4a0ca53a1c
```
            
#### Ответ


```javascript
{
  &quot;messages&quot;: [
    {
      &quot;timestamp&quot;: 1596470953,
      &quot;sender&quot;: {
        &quot;id&quot;: &quot;d8d9f9c4-9611-4794-a136-a253a13e1bb5&quot;,
        &quot;name&quot;: &quot;Менеджер Василий&quot;
      },
      &quot;receiver&quot;: {
        &quot;id&quot;: &quot;86a0caef-41ec-49ac-814b-b27da2cea267&quot;,
        &quot;client_id&quot;: &quot;sk-1376265f-86df-4c49-a0c3-a4816df41af9&quot;,
        &quot;avatar&quot;: &quot;https:/example.com/users/avatar.png&quot;,
        &quot;name&quot;: &quot;Example Client&quot;,
        &quot;phone&quot;: &quot;79151112233&quot;,
        &quot;email&quot;: &quot;example.client@example.com&quot;
      },
      &quot;message&quot;: {
        &quot;id&quot;: &quot;3985523d-78b3-45b7-aeaf-142405bbf1dc&quot;,
        &quot;client_id&quot;: &quot;skm-5f2836a8ca468&quot;,
        &quot;type&quot;: &quot;text&quot;,
        &quot;text&quot;: &quot;Да, конечно. Вы можете оплатить наличными и картой курьеру при получении.&quot;
        &quot;media&quot;: &quot;&quot;,
        &quot;thumbnail&quot;: &quot;&quot;,
        &quot;file_name&quot;: &quot;&quot;,
        &quot;file_size&quot;: 0
      }
    },
    {
      &quot;timestamp&quot;: 1596470809,
      &quot;sender&quot;: {
        &quot;id&quot;: &quot;86a0caef-41ec-49ac-814b-b27da2cea267&quot;,
        &quot;client_id&quot;: &quot;sk-1376265f-86df-4c49-a0c3-a4816df41af9&quot;,
        &quot;avatar&quot;: &quot;https:/example.com/users/avatar.png&quot;,
        &quot;name&quot;: &quot;Example Client&quot;,
        &quot;phone&quot;: &quot;79151112233&quot;,
        &quot;email&quot;: &quot;example.client@example.com&quot;
      },
      &quot;message&quot;: {
        &quot;id&quot;: &quot;1bf6a765-ec6f-4680-8cd5-6f2d31f78ebc&quot;,
        &quot;client_id&quot;: &quot;5f283618af2c8&quot;,
        &quot;type&quot;: &quot;text&quot;,
        &quot;text&quot;: &quot;Можно ли оплатить заказ при получении ?&quot;
        &quot;media&quot;: &quot;&quot;,
        &quot;thumbnail&quot;: &quot;&quot;,
        &quot;file_name&quot;: &quot;&quot;,
        &quot;file_size&quot;: 0
      }
    }
  ]
}
```<!-- Generated at Tue, 02 Mar 2021 14:45:14 +0000. amoCRM Documentation Generator -->