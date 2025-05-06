<h1>Create user</h1>

<form method="post">
    {% if isset($_SESSION['errors']) %}
    {% foreach error in ($_SESSION['errors']) %}
    <li style="color: red">{{ error }}</li>
    {% endforeach %}
    {% endif %}

    <label>
        First name:
        <input type="text" name="first_name" placeholder="Имя">
    </label>
    <br>

    <label>
        Last name:
        <input type="text" name="last_name" placeholder="Фамилия">
    </label>
    <br>

    <label>
        City:
        <select name="city_id">
            {% foreach city in cities %}
            <option value="{{ city.id }}">
                {{ city.city }}
            </option>
            {% endforeach %}
        </select>
    </label>
    <br>

    <input type="submit" value="Создать">
</form>
