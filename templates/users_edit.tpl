<h1>Редактировать пользователя {$user['id']}</h1>

<form method="post" action="">

    {if session('errors')}
        <ul>
            {foreach session('errors') as $error}
                <li style="color: red">{$error}</li>
            {/foreach}
        </ul>
    {/if}

    <p><strong>ID:</strong> {$user['id']}</p>

    <label>
        Город:
        <select name="city_id" required>
            <option value="">-- выберите город --</option>
            {foreach $cities as $city}
                <option value="{$city->getId()}" {if $user->getId() == $city->getId()}selected{/if}>
                    {$city['city']}
                </option>
            {/foreach}
        </select>
    </label>
    <br>

    <label>
        Имя:
        <input type="text" name="first_name" required value="{$user['first_name']}">
    </label>
    <br>

    <label>
        Фамилия:
        <input type="text" name="last_name" value="{$user['last_name']}">
    </label>
    <br>

    <input type="submit" value="Сохранить">
</form>
