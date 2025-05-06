<h1>Edit {{ city.city  }} </h1>

<form method="post" action="">
    <label>
        City Name:
        {% if isset($errors) %}
            {% foreach error in errors %}
            <li style="color: red">{{ error }}</li>
            {% endforeach %}
        {% endif %}

        <input type="text" name="city" value="{{ city.city }}">

    </label>
    <label for="">
        Country:
        <select name="country_id">
            {% foreach country in countries %}
            <option value={{ country.id }}>{{ country.country }}</option>
            {% endforeach %}
        </select>
    </label>
    <input type="submit" value="Edit">
</form>